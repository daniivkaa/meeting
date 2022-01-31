<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends MainController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em): Response
    {

        $activeMeeting = $em->getRepository(Meeting::class)->findBy(['isActive' => true], ['date' => 'DESC']);


        return $this->renderPage('page/index.html.twig', [
            'activeMeeting' => $activeMeeting
        ]);
    }
}
