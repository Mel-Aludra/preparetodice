<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\Front\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if($authenticationUtils->getLastAuthenticationError() !== null)
            $this->addFlash("error", "Wrong username or password");
        $username = $authenticationUtils->getLastUsername();
        return $this->render('front/user/login.html.twig', [
            "username" => $username
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/user/add", name="front_user_add")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function addUser(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Captcha
            if($this->checkCaptcha()) {

                $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
                $manager->persist($user);
                $manager->flush();

                //Send mail
                $email = new TemplatedEmail();
                $email->from("contact@morbol.fr")
                    ->to($user->getEmail())
                    ->subject("[Preparetodice] - Registration")
                    ->htmlTemplate('mails/register.html.twig')
                    ->context(["user" => $user]);
                $mailer->send($email);

                //Flash and redirection
                $this->addFlash("success", "Your account have been created! You can now login to Prepare to dice.");
                return $this->redirectToRoute('login');

            } else {
                $this->addFlash("error", "You are a robot.");
            }

        }
        return $this->render('front/user/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/update", name="front_user_update")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function updateUser(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserType::class, $this->getUser());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->getUser()->setPassword($passwordEncoder->encodePassword($this->getUser(), $this->getUser()->getPassword()));
            $manager->persist($this->getUser());
            $manager->flush();
        }
        return $this->render('front/user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function checkCaptcha()
    {
        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LdiH3QaAAAAALIdbD-XtDXIfkm006WGtz3uGDlL';
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
            return true;
        } else {
            return false;
        }
    }
}
