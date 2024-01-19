<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'tasklinker_project_list', methods: ['GET'])]
    public function list(): Response
    {
        $projects = [
            'Project 1',
            'Project 2',
            'Project 3',
            'Project 4',
        ];

        return $this->render('project/list.html.twig', [
            'pageName' => 'Liste des projets',
            'projects' => $projects,
        ]);
    }

    #[Route('/project', name: 'tasklinker_project_create', methods: ['GET'])]
    public function create(Request $request): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return $this->render('project/create.html.twig', [
            'pageName' => 'Créer un projet',
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}', name: 'tasklinker_project_read', methods: ['GET'])]
    public function read(Project $project): Response
    {
        return $this->render('project/create.html.twig', [
            'pageName' => 'Créer un projet',
        ]);
    }
}
