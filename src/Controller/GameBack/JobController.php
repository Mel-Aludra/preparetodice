<?php

namespace App\Controller\GameBack;

use App\Entity\Job;
use App\Form\GameBack\EntitiesFilterType;
use App\Form\GameBack\JobType;
use App\Repository\JobRepository;
use App\Service\EntitiesFilterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JobController
 * @package App\Controller\GameBack
 * @Route("/back/{game}/job")
 */
class JobController extends Controller
{
    /**
     * @Route("/list/{page<\d+>?1}", name="gameBack_job_list")
     * @param JobRepository $repo
     * @param int $page
     * @param Request $request
     * @return Response
     */
    public function list(JobRepository $repo, int $page, Request $request)
    {
        //Manage paging with filters and ordering post
        $entitiesFiltersForm = $this->createForm(EntitiesFilterType::class, null, [
            "filtersElements" => ["name", "description"],
            "sortingElements" => ["id", "name"]
        ]);
        $entitiesFiltersService = new EntitiesFilterService($repo, $page, 'gameBack_job_list', $this->getGame(), $entitiesFiltersForm, $request);

        //Return view
        return $this->render('back/job/list.html.twig', [
            'jobs' => $entitiesFiltersService->getEntities(),
            'entitiesFiltersService' => $entitiesFiltersService->createView()
        ]);
    }

    /**
     * @Route("/add", name="gameBack_job_add")
     * @Route("/update/{job}", name="gameBack_job_update")
     * @param EntityManagerInterface $manager
     * @param Request                $request
     * @param Job|null     $job
     *
     * @return Response
     */
    public function addAndUpdateJob(EntityManagerInterface $manager, Request $request, ?Job $job)
    {
        //Get context (update or add)
        $context = $this->getFormContext();

        //Check entity / create if null / check if from this game
        if($context === "add")
            $job = new Job();
        else
            $this->checkEntityGameContext($job);

        //Create form and handle request
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $job->setGame($this->getGame());
            $manager->persist($job);
            $this->getGame()->addJob($job);
            $manager->flush();

            //Flush and flash
            $manager->flush();
            $message = "Job " . $job->getName() . " have been created.";
            if($context == "update")
                $message = "Job " . $job->getName() . " have been updated.";
            $this->addFlash("success", $message);

            return $this->redirectToRoute('gameBack_job_list', ['game' => $this->getGame()->getId()]);
        }

        //Render page
        return $this->render('back/job/edit.html.twig', [
            'form' => $form->createView(),
            'job' => $job,
            'context' => $context
        ]);
    }

    /**
     * @Route("/delete/{job}", name="gameBack_job_delete")
     * @param EntityManagerInterface $manager
     * @param Job|null $job
     * @return Response
     */
    public function delete(Job $job, EntityManagerInterface $manager)
    {
        $manager->remove($job);
        $manager->flush();
        $this->addFlash("success", "Job " . $job->getName() . " have been deleted.");
        return $this->redirectToRoute('gameBack_job_list', ['game' => $this->getGame()->getId()]);
    }
}
