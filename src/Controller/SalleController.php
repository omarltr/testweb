<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
        ]);
    }

    #[Route('/show', name: 'showsalle')]

    public function show(SalleRepository $salleRepository): Response
    {
        $rep = $salleRepository->findAll();
        return $this->render('salle/show.html.twig', ['salles' => $rep]);
    }




    #[Route('/add', name: 'addsalle')]
    public function addSalle(ManagerRegistry $managerRegistry, Request $request): Response
    {
$salle= new Salle();
$form=$this->createForm(SalleType::class, $salle);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
    $em= $this->getDoctrine()->getManager();
    $em->persist($salle);
    $em->flush();
    return $this->redirectToRoute('showsalle');
}return $this->render(  'salle/form.html.twig',['f'=>$form->createView(),]);
    

}



#[Route('/update{id}', name: 'updatesalle')]
public function edit (ManagerRegistry $managerRegistry,SalleRepository $salleRepository, Request $request,$id): Response{


$salle=$salleRepository->find( $id );
$form=$this->createForm(SalleType::class, $salle);
$form->handleRequest($request); 
if ($form->isSubmitted() && $form->isValid()) {
    $em= $this->getDoctrine()->getManager();    
    $em->persist($salle);
    $em->flush();
    return $this->redirectToRoute('showsalle');

}
return $this->render(  'salle/form.html.twig',['f'=>$form->createView(),]);

}

#[Route('/delete{id}', name: 'deletesalle')]
public function delete(  SalleRepository $salleRepository, $id,ManagerRegistry $doctrine): Response{

$managerRegistry=$doctrine->getManager();
$salle=$salleRepository->find($id);
$managerRegistry->remove($salle);
$managerRegistry->flush();
return $this->redirectToRoute('showsalle');


}
/*
#[Route('/show{id}', name: 'showsalle')]
public function show(){


    
}*/

}
