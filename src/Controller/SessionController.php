<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="session")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $sessions = $em->getRepository(Session::class)->findBy([
            'user' => $user
        ]);

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
    /**
     * @Route("/session/create", name="session_create")
     */
    public function sessionCreate(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if($sessionForm->isSubmitted() && $sessionForm->isValid()){
            $session->setUser($user);

            $em->persist($session);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('session/create.html.twig', [
            'sessionForm' => $sessionForm->createView(),
        ]);
    }

    /**
     * @Route("/session/show/{session}", name="session_show")
     */
    public function sessionShow(Session $session, EntityManagerInterface $em): Response
    {

        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/session/delete/{session}", name="session_delete")
     */
    public function sessionDelete(Session $session, EntityManagerInterface $em): Response
    {
        $em->remove($session);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
