<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategoryType;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProgramController extends AbstractController
{
    /**
     * @Route("/program", name="program_index")
     */

    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render('program/index.html.twig', [
            'programs' => 'programs',
        ]);
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */

    public function new(Request $request) : Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $entityManager = $this->$doctrine->getManager();
            $entityManager->persist($program);
            $entityManager->flush();
            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('program/new.html.twig', [
            "form" => $form,
        ]);

    }

    /**
     ** @Route("/{program}/", name="show", methods="GET", requirements={"id"="\d{1,}"})
     */
    public function show(Program $program): Response
    {
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findByProgram($program);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/{program}/season/{season}/", name="season_show")
     */
    Public function showSeason (Program $program, Season $season): Response
    {
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBySeason($season);

        return $this->render('/program/season_show.html.twig',
            ['program'  => $program,
                'season'   => $season,
                'episodes' => $episodes,
            ]);
    }

    /**
     * @Route("/{program}/seasons/{season}/episode/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('/program/episode_show.html.twig',
            ['program' => $program,
                'season'  => $season,
                'episode' => $episode,
            ]);
    }

}

