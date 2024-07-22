<?php

namespace App\Controller;

use App\Entity\FamilyMember;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FamilyMemberController extends AbstractController
{
    #[Route('/family/member', name: 'family_member_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $familyMembers = $entityManager->getRepository(FamilyMember::class)->findAll();

        return $this->render('family_member/index.html.twig', [
            'controller_name' => 'FamilyMemberController',
            'family_members' => $familyMembers,
        ]);
    }
    
    #[Route('/family/member/add', name: 'app_family_member_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()
                     ->add('name', TextType::class)
                     ->add('save', SubmitType::class, ['label' => 'Add Family Member'])
                     ->getForm();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $familyMember = new FamilyMember();
            $familyMember->setName($form->get('name')->getData());
            
            $entityManager->persist($familyMember);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_family_member_view', ['id' => $familyMember->getId()]);
        }
        
        return $this->render('family_member/add.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/family/member/{id}', name: 'app_family_member_view')]
    public function view(EntityManagerInterface $entityManager, int $id): Response
    {
        $familyMember = $entityManager->getRepository(FamilyMember::class)->find($id);

        if (!$familyMember) {
            throw $this->createNotFoundException(
                'No family member found for id ' . $id
            );
        }

        return $this->render('family_member/view.html.twig', [
            'controller_name' => 'FamilyMemberController',
            'family_member' => $familyMember,
        ]);
    }
    
}
