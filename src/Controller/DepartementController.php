<?php

// src/Controller/DepartementController.php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'departement_index')]
    public function index(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAll();

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
        ]);
    }

    #[Route('/departement/add', name: 'departement_add')]
    public function addDepartement(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departement);
            $em->flush();

            return $this->redirectToRoute('departement_index');
        }

        return $this->render('departement/form.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/departement/edit/{id}', name: 'departement_edit')]
    public function editDepartement(int $id, Request $request, ManagerRegistry $managerRegistry, DepartementRepository $departementRepository): Response
    {
        $departement = $departementRepository->find($id);
    
        if (!$departement) {
            throw $this->createNotFoundException('Departement not found');
        }
    
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
    
            return $this->redirectToRoute('departement_index');
        }
    
        return $this->render('departement/form.html.twig', ['form' => $form->createView()]);
    }
    

    #[Route('/departement/delete/{id}', name: 'departement_delete')]
    public function deleteDepartement(int $id, ManagerRegistry $doctrine, DepartementRepository $departementRepository): Response
    {
        $managerRegistry = $doctrine->getManager();
        $departement = $departementRepository->find($id);
    
        if ($departement) {
            $managerRegistry->remove($departement);
            $managerRegistry->flush();
        }
    
        return $this->redirectToRoute('departement_index');
    }
    
}

