<?php

namespace App\Controller\Front;

use App\Entity\PasswordReset;
use App\Repository\PasswordResetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordResetController extends AbstractController
{

    /**
     * @Route("/password/ask", name="front_password_ask")
     */
    public function askReset(UserRepository $userRepository, EntityManagerInterface $manager, MailerInterface $mailer)
    {
        $ask = false;
        if(isset($_POST["username"])) {
            $ask = true;
            $user = $userRepository->findOneBy(["name" => $_POST["username"]]);
            if($user !== null) {
                $passwordReset = new PasswordReset();
                $passwordReset->setUser($user);
                $expiration = new \DateTime();
                date_modify($expiration, '2 days');
                $passwordReset->setExpirationDate($expiration);
                $passwordReset->setHash(md5(uniqid() . "salt_9831"));
                $passwordReset->setDone(false);
                $passwordReset->setEmail($user->getEmail());
                $user->addPasswordReset($passwordReset);
                $manager->persist($passwordReset);
                $manager->flush();

                //Send mail
                $email = new TemplatedEmail();
                $email->from("contact@morbol.fr")
                    ->to($user->getEmail())
                    ->subject("[Preparetodice] - Reset password")
                    ->htmlTemplate('mails/password.html.twig')
                    ->context(["reset" => $passwordReset]);
                $mailer->send($email);
            }
        }
        return $this->render('front/password-reset/ask.html.twig', [
            'ask' => $ask
        ]);
    }

    /**
     * @Route("/password/reset/{id}/{hash}/{email}", name="front_password_reset")
     * @param int $id
     * @param string $hash
     * @param string $email
     * @param PasswordResetRepository $passwordResetRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function resetPassword(int $id, string $hash, string $email, PasswordResetRepository $passwordResetRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {

        //Case of post
        if(isset($_POST["hash"])) {
            if($_POST["hash"] === $hash) {
                $reset = $passwordResetRepository->findOneBy(["id" => $id, "hash" => $hash, "email" => $email]);
                if($_POST["password"] === $_POST["check_password"]) {
                    if($reset !== null && $reset->getExpirationDate() > new \DateTime() && !$reset->getDone()) {
                        $user = $reset->getUser();
                        $user->setPassword($passwordEncoder->encodePassword($user, $_POST["password"]));
                        $manager->persist($user);
                        $reset->setDone(true);
                        $manager->persist($reset);
                        $manager->flush();
                        $this->addFlash("success", "Your password have been reset. You can now login.");
                        return $this->redirectToRoute("login");
                    }
                } else {
                    $this->addFlash("error", "Passwords don't match");
                }
            }
        }

        $reset = $passwordResetRepository->findOneBy(["id" => $id, "hash" => $hash, "email" => $email]);
        if($reset !== null) {
            if($reset->getExpirationDate() > new \DateTime() && !$reset->getDone()) {
                return $this->render('front/password-reset/reset.html.twig', [
                    'reset' => $reset
                ]);
            }
        }
        $this->addFlash("error", "Invalid parameters");
        return $this->redirectToRoute("front_password_ask");
    }

}
