<?php

namespace App\Controller;

use App\Entity\FamilyMember;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
            'breadcrumbs' => [
                [
                    'caption' => 'Family members',
                    'active' => true,
                ],
            ],
        ]);
    }
    
    #[Route('/family/member/add', name: 'family_member_add')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new FamilyMember();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            // do anything else you need here, like send an email
            
            return $this->redirectToRoute('family_member_view', ['id' => $user->getId()]);
        }
        
        return $this->render('family_member/add.html.twig', [
            'form' => $form,
            'breadcrumbs' => [
                [
                    'caption' => 'Family members',
                    'url' => $this->generateUrl('family_member_list'),
                ],
                [
                    'caption' => 'Add family member',
                    'active' => true,
                ],
            ],
        ]);
    }
    
    #[Route('/family/member/{id}', name: 'family_member_view')]
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
            'breadcrumbs' => [
                [
                    'caption' => 'Family members',
                    'url' => $this->generateUrl('family_member_list'),
                ],
                [
                    'caption' => $familyMember->getName(),
                    'active' => true,
                ],
            ],
        ]);
    }
    
}
