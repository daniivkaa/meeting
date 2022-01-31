<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    public $em;


    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function renderPage(string $twig, array $vars): Response
    {
        $sessions = $this->em->getRepository(Session::class)->findAll();

        $reqValues = [
            'sessions' => $sessions,
        ];

        $result = array_merge($vars, $reqValues);

        return $this->render($twig, $result);
    }
}
