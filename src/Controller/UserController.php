<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_profil')]
    public function ModificationProfil(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid()){
           $user->setPassword(
               $userPasswordHasher->hashPassword($user,
               $form->get('password')->getData()

           ) );
           $entityManager->persist($user);
           $entityManager->flush();

           $this->addFlash('succes', 'Profil modifié avec succés !');

       return $this->redirectToRoute('main_home',['id'=>$user->getId()]);
       }
        return $this->render('user/profil.html.twig', [
           'RegistrationFormType'=>$form->createView(),
            'controller_name' => 'UserController',
        ]);
    }

}
