<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Subject;
use App\Form\MeetingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{
    /**
     * @Route("/meeting/{subject}", name="meeting")
     */
    public function index(Subject $subject, EntityManagerInterface $em): Response
    {
        $meetings = $em->getRepository(Meeting::class)->findBy([
            "subject" => $subject
        ]);

        return $this->render('meeting/index.html.twig', [
            'meetings' => $meetings,
        ]);
    }

    /**
     * @Route("/meeting/create/{subject}", name="meeting_create")
     */
    public function meetingCreate(Subject $subject, EntityManagerInterface $em, Request $request): Response
    {
        $meeting = new Meeting();

        $meetingForm = $this->createForm(MeetingType::class, $meeting);
        $meetingForm->handleRequest($request);

        if($meetingForm->isSubmitted() && $meetingForm->isValid()){
            $meeting->setSubject($subject);
            $meeting->setIsActive(true);

            $em->persist($meeting);
            $em->flush();

            return $this->redirectToRoute("subject_show", ['subject' => $subject->getId()]);
        }

        return $this->render('meeting/create.html.twig', [
            'meetingForm' => $meetingForm->createView(),
        ]);
    }

    /**
     * @Route("/meeting/show/{meeting}", name="meeting_show")
     */
    public function meetingShow(Meeting $meeting, EntityManagerInterface $em): Response
    {

        return $this->render('meeting/show.html.twig', [
            'meeting' => $meeting,
        ]);
    }
}
