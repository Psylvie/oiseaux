<?php

namespace App\Controller;

use App\Entity\Oiseau;
use App\Form\OiseauType;
use App\Repository\OiseauRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oiseaux', name: 'oiseau_')]
class OiseauController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(OiseauRepository $oiseauRepository): Response
    {
        $oiseaux=$oiseauRepository->findAll();
        return $this->render('oiseau/list.html.twig', [

            'oiseaux'=>$oiseaux
            //            'controller_name' => 'OiseauController',
        ]);
    }
    #[Route("/details/{id}", name: 'details')]
    public function details(int $id, OiseauRepository $oiseauRepository): Response{
        $oiseau=$oiseauRepository->find($id);
        return $this->render('oiseau/details.html.twig',[
            'oiseau'=>$oiseau
        ]);
    }

    #[Route("/create", name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager):Response

    {
        $oiseau=new Oiseau();
        $oiseau->setUser($this->getUser());
        $oiseauForm = $this->createForm(OiseauType::class, $oiseau);

        $oiseauForm->handleRequest($request);
        if ($oiseauForm->isSubmitted() && $oiseauForm->isValid()){
            $entityManager->persist($oiseau);
            $entityManager->flush();
            $this->addFlash('succes', 'fiche oiseau ajoutée avec succés ! ');
            return $this->redirectToRoute('oiseau_details', ['id'=>$oiseau->getId()]);
        }

        return $this->render("oiseau/create.html.twig", [
            'oiseauForm'=>$oiseauForm->createView()
        ]);
    }
}
