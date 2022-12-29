<?php

namespace App\Controller;

use App\Manager\DrawManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(DrawManager $drawManager): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'average' => $drawManager->getAverageAll(),
        ]);
    }
}
