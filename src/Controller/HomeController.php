<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param MissionRepository $repository
     * @return Response
     */
    public function home(MissionRepository $repository): Response
    {
        $missions = $repository->findLatest();
        return $this->render('home/home.html.twig', [
            'missions' => $missions
        ]);
    }

}
