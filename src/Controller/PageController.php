<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $sessions = $em->getRepository(Session::class)->findAll();

        $activeMeeting = $em->getRepository(Meeting::class)->findBy(['isActive' => true]);


        return $this->render('page/index.html.twig', [
            'sessions' => $sessions,
            'activeMeeting' => $activeMeeting
        ]);
    }
}
