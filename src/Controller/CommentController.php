<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Meeting;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/create/{meeting}", name="comment_create")
     */
    public function commentCreate(Meeting $meeting, EntityManagerInterface $em, Request $request): Response
    {
        $comment = new Comment();

        $commentForm = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_create', [
                'meeting' => $meeting->getId()
            ]),
            'method' => 'POST'
        ]);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setMeeting($meeting);

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute("meeting_show", ["meeting" => $meeting->getId()]);
        }

        return $this->render('comment/create.html.twig', [
            'commentForm' => $commentForm->createView(),
            'meeting' => $meeting
        ]);
    }
}
