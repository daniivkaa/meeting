<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Subject;
use App\Form\MeetingEditType;
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
            $meeting->setState("Активна");
            $meeting->setDate(new \DateTime('now'));

            $em->persist($meeting);
            $em->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('meeting/create.html.twig', [
            'meetingForm' => $meetingForm->createView(),
        ]);
    }

    /**
     * @Route("/meeting/show/{meeting}", name="meeting_show")
     */
    public function meetingShow(Meeting $meeting, EntityManagerInterface $em, Request $request): Response
    {

        $meetingEditForm = $this->createForm(MeetingEditType::class, $meeting);
        $meetingEditForm->handleRequest($request);

        if($meetingEditForm->isSubmitted() && $meetingEditForm->isValid() && $meeting->getIsActive()){

            $em->persist($meeting);
            $em->flush();
        }

        return $this->render('meeting/show.html.twig', [
            'meeting' => $meeting,
            'meetingEditForm' => $meetingEditForm->createView()
        ]);
    }

    /**
     * @Route("/meeting/end/successful/{meeting}", name="meeting_end_successful")
     */
    public function meetingEndSuccessful(Meeting $meeting, EntityManagerInterface $em, Request $request): Response
    {
        $meeting->setIsActive(false);
        $meeting->setIsSuccessful(true);
        $meeting->setState("Состоялась");

        $em->persist($meeting);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/meeting/end/unsuccessful/{meeting}", name="meeting_end_unsuccessful")
     */
    public function meetingEndUnsuccessful(Meeting $meeting, EntityManagerInterface $em): Response
    {
        $meeting->setIsActive(false);
        $meeting->setIsSuccessful(false);
        $meeting->setState("Не состоялась");

        $em->persist($meeting);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/meeting/delete/{meeting}", name="meeting_delete")
     */
    public function meetingDelete(Meeting $meeting, EntityManagerInterface $em): Response
    {
        $em->remove($meeting);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
