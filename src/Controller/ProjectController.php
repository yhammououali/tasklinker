<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'tasklinker_project_list', methods: ['GET'])]
    public function list(ProjectRepository $projectRepository): Response
    {
        /* $projects = [
            'Project 1',
            'Project 2',
            'Project 3',
            'Project 4',
        ]; */

        $projects = $projectRepository->findByActive();

        return $this->render('project/list.html.twig', [
            'pageName' => 'Liste des projets',
            'projects' => $projects,
        ]);
    }

    #[Route('/project', name: 'tasklinker_project_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
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

    #[Route('/project/{id}/update', name: 'tasklinker_project_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }

        return $this->render('project/create.html.twig', [
            'pageName' => sprintf('Mis à jour du projet [%s]', $project->getTitle()),
            'form' => $form,
        ]);
    }

    #[Route('/project/{id}/delete', name: 'tasklinker_project_delete', methods: ['GET'])]
    public function delete(Project $project, EntityManagerInterface $entityManager): Response
    {
        $project->setDeletedAt(new \DateTimeImmutable());
        $entityManager->flush();

        return $this->redirectToRoute('tasklinker_project_list');
    }
}
