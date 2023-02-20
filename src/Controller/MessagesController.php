<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'app_messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
    #[Route('/send', name: 'send')]
    public function send(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class,$message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $message->setSender($this->getUser());
            $entityManager ->persist($message);
            $entityManager->flush();
            $this->addFlash('message', 'message envoyé avec succés ! ');
            return $this->redirectToRoute('app_messages');


        }
        return $this->render('messages/send.html.twig', [
            'form'=> $form->createView()

        ]);
    }


    #[Route('/received', name: 'received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }
    #[Route('/read/{id}', name: 'read')]
    public function read(Messages $message, Request $request, EntityManagerInterface $entityManager): Response
    {
        $message->setIsRead(true);
        $entityManager->persist($message) ;
        $entityManager->flush();
        return $this->render('messages/read.html.twig', compact('message'));
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Messages $message, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($message);
        $entityManager->flush();
        return $this->redirectToRoute('received');
    }

    #[Route('/sent', name: 'sent')]
    public function sent(): Response
    {
        return $this->render('messages/sent.html.twig');
    }
}
