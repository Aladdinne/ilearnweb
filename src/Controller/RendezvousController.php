<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\UserRepository;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class RendezvousController extends AbstractController
{
    #[Route('/rendezvous', name: 'app_rendezvous')]
    public function index(): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'controller_name' => 'RendezvousController',
        ]);
    }
    #[Route('/AfficheRendezvous',name:'ffr')]
    function Affiche (RendezvousRepository $rep,UserRepository $repp ){
        $user = $repp->findAll();
        $rendezvous = $rep->findall();
        return $this->render('rendezvous/Affiche1.html.twig',['rr'=>$rendezvous,'cc'=>$user]);
    }
    #[Route('/Ajoutrendezvous',name:'ajoutrendezvous')]
    function Ajout(ManagerRegistry $doctrine,Request $request){
        $rendezvous=new Rendezvous;
        $form=$this->createFormBuilder($rendezvous)
            ->add('daterdv')
            ->add('dureerdv')
            ->add('tel')
            ->add('motif')
            ->add('etatrdv')
            ->add('idclient')
            ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($rendezvous);
            $em->flush();
            return $this->redirectToRoute('ffr');
        }
        return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Delete/{id}', name:'remove')]
    function delete(ManagerRegistry $doctrine,Rendezvous $rendezvous){
        $em=$doctrine->getManager();
        $em->remove($rendezvous);
        $em->flush();
        return $this->redirectToRoute('ffr');
    }
    #[Route('/Update/{id}', name:'Update')]
    function Update(ManagerRegistry $doctrine,Rendezvous $rendezvous,Request $req){
      $form=$this->createForm(RendezvousType::class,$rendezvous)
      ->add('Update',SubmitType::class);       
  $form->handleRequest($req);
  if($form->isSubmitted() && $form->isValid()){
      $em=$doctrine->getManager();
      $em->flush();
  return $this->redirectToRoute('ffr');
  }
  return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
    }
}
