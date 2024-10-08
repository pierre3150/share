<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Fichier;
use App\Form\FichierType;

class FichierController extends AbstractController
{
    #[Route('/ajout-fichier', name: 'app_ajout_fichier')]
    public function ajout_fichier(Request $request, EntityManagerInterface $em): Response
    {
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $fichier->setDateEnvoi(new \Datetime());
                $em->persist($fichier);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('app_ajout_fichier');

            }
        }

        return $this->render('fichier/ajout_fichier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mod-liste-fichiers', name: 'app_liste_fichiers')]
    public function listeFichiers(FichiersRepository $fichiersRepository): Response
    {
        $fichiers = $fichiersRepository->findAll();
        return $this->render('fichier/liste-fichiers.html.twig', [
            'fichiers' => $fichiers
        ]);
    }
}
