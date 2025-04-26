<?php

namespace App\Controller;

use App\Entity\Assignment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AssignmentController extends AbstractController
{
    #[Route('/assignment', name: 'assignment_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $assignments = $entityManager->getRepository(Assignment::class)->findAll();
        
        return $this->render('assignment/index.html.twig', [
            'controller_name' => 'AssignmentController',
            'assignments' => $assignments,
            'breadcrumbs' => [
                [
                    'caption' => 'Assignments',
                    'active' => true,
                ],
            ],
        ]);
    }
    
    #[Route('/assignment/add', name: 'assignment_add')]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $form = $this->createFormBuilder([
            'date_set' => new \DateTimeImmutable('now')
        ])
        ->add('title', TextType::class)
        ->add('instructions', TextareaType::class)
        ->add('date_set', DateType::class)
        ->add('add', SubmitType::class)
        ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $assignment = new Assignment();
            $assignment->setTitle($form->get('title')->getData());
            $assignment->setInstructions($form->get('instructions')->getData());
            $assignment->setDateSet($form->get('date_set')->getData());
            
            $entityManager->persist($assignment);
            $entityManager->flush();
            
            return $this->redirectToRoute('assignment_view', ['id' => $assignment->getId()]);
        }
        
        return $this->render('assignment/add.html.twig', [
            'form' => $form,
            'breadcrumbs' => [
                [
                    'caption' => 'Assignments',
                    'url' => $this->generateUrl('assignment_list'),
                ],
                [
                    'caption' => 'Add Assignment',
                    'active' => true,
                ],
            ],
        ]);
    }
    
    #[Route('/assignment/{id}', name: 'assignment_view')]
    public function view(EntityManagerInterface $entityManager, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $assignment = $entityManager->getRepository(Assignment::class)->find($id);
        
        if (!$assignment) {
            throw $this->createNotFoundException(
                'No assignment found for id ' . $id
            );
        }
        
        return $this->render('assignment/view.html.twig', [
            'controller_name' => 'AssignmentController',
            'assignment' => $assignment,
            'breadcrumbs' => [
                [
                    'caption' => 'Assignments',
                    'url' => $this->generateUrl('assignment_list'),
                ],
                [
                    'caption' => $assignment->getTitle(),
                    'active' => true,
                ],
            ],
        ]);
    }
    
    #[Route('/assignment/{id}/edit', name: 'assignment_edit')]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $assignment = $entityManager->getRepository(Assignment::class)->find($id);
        
        if (!$assignment) {
            throw $this->createNotFoundException(
                'No assignment found for id ' . $id
            );
        }
        
        return new Response();
    }
}
