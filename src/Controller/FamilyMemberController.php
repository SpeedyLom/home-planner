<?php

namespace App\Controller;

use App\Entity\FamilyMember;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
