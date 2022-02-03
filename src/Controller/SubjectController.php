<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Session;
use App\Entity\Subject;
use App\Form\MeetingType;
use App\Form\SubjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubjectController extends MainController
{
    /**
     * @Route("/subject/{session}", name="subject")
     */
    public function index(Session $session, EntityManagerInterface $em): Response
    {
        $subjects = $em->getRepository(Subject::class)->findBy([
            "session" => $session
        ]);

        return $this->renderPage('subject/index.html.twig', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * @Route("/subject/create/{session}", name="subject_create")
     */
    public function subjectCreate(Session $session, EntityManagerInterface $em, Request $request): Response
    {
        $subject = new Subject();

        $subjectForm = $this->createForm(SubjectType::class, $subject);
        $subjectForm->handleRequest($request);

        if($subjectForm->isSubmitted() && $subjectForm->isValid()){

            $subject->setSession($session);

            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute("session_show", ['session' => $session->getId()]);
        }

        return $this->renderPage('subject/create.html.twig', [
            'subjectForm' => $subjectForm->createView(),
        ]);
    }

    /**
     * @Route("/subject/show/{subject}", name="subject_show")
     */
    public function subjectShow(Subject $subject, EntityManagerInterface $em, Request $request): Response
    {

        $activeMeeting = $em->getRepository(Meeting::class)->findBy(['isActive' => true, "subject" => $subject], ['date' => 'DESC']);
        $historyMeeting = $em->getRepository(Meeting::class)->findBy(['isActive' => false, "subject" => $subject], ['date' => 'DESC']);

        $meeting = new Meeting();

        $meetingForm = $this->createForm(MeetingType::class, $meeting);
        $meetingForm->handleRequest($request);

        if($meetingForm->isSubmitted() && $meetingForm->isValid()){
            $meeting->setSubject($subject);
            $meeting->setIsActive(true);
            $meeting->setState("Активна");
            $meeting->setDate(new \DateTime('now'));

            $em->persist($meeting);
            $em->flush();

            return $this->redirectToRoute("subject_show", ['subject' => $subject->getId()]);
        }


        return $this->renderPage('subject/show.html.twig', [
            'subject' => $subject,
            'activeMeeting' => $activeMeeting,
            'historyMeeting' => $historyMeeting,
            'meetingForm' => $meetingForm->createView(),
        ]);
    }

    /**
     * @Route("/subject/delete/{subject}", name="subject_delete")
     */
    public function subjectDelete(Subject $subject, EntityManagerInterface $em): Response
    {

        $em->remove($subject);
        $em->flush();

        return $this->redirectToRoute('session_show', ['session' => $subject->getSession()->getId()]);
    }
}
