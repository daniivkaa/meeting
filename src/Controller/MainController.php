<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Session;
use App\Entity\Subject;
use App\Form\SessionType;
use App\Form\SubjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $request = new Request(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER
        );

        $user = $this->getUser();

        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if($sessionForm->isSubmitted() && $sessionForm->isValid()){
            $session->setUser($user);

            $this->em->persist($session);
            $this->em->flush();

            return $this->redirectToRoute('home');
        }

        $subject = new Subject();

        $subjectForm = $this->createForm(SubjectType::class, $subject);
        $subjectForm->handleRequest($request);

        if($subjectForm->isSubmitted() && $subjectForm->isValid()){

            $sessionId = $subjectForm->get("sessionId")->getData();
            $sessionSubject = $this->em->getRepository(Session::class)->findOneBy(["id" => $sessionId]);
            $subject->setSession($sessionSubject);

            $this->em->persist($subject);
            $this->em->flush();

            return $this->redirectToRoute("home");
        }

        $reqValues = [
            'sessions' => $sessions,
            'sessionForm' => $sessionForm->createView(),
            'subjectForm' => $subjectForm->createView(),
        ];

        $result = array_merge($vars, $reqValues);

        return $this->render($twig, $result);
    }
}
