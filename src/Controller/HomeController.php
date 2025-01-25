<?php

namespace App\Controller;

use App\Entity\FamilyMember;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('homepage.html.twig',
        [
            'breadcrumbs' => [
                [
                    'caption' => 'Dashboard',
                    'active' => true,
                ],
            ],
        ]);
    }
}
