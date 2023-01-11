<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    /**
     * @Route("/program/", name="app_program")
     */

    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'programme' => 'Deezer',
        ]);
    }

    /**
     * @Route("/program/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="program_id")
     */

    public function show (int $id): Response
    {
        return $this->render('program/show.html.twig', [
            'id' => $id,
        ]);
    }
}