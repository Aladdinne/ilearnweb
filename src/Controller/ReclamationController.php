<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    #[Route('/Affichereclamation2',name:'aff')]
        function Affiche2(ReclamationRepository $repo,UserRepository $repp){
            $reclamation = new Reclamation();
            $user = new User();
            $reclamation=$repo->findAll();
            $user=$repp->findAll();
            return $this->render('reclamation/Affichereclamation.html.twig',
           ['cc'=>$reclamation,'ff'=>$user]);
        }
        #[Route('/Delete/{id}',name:'DD')]
        function Delete(ManagerRegistry $doctrine ,Reclamation $reclamation){
         $em=$doctrine->getManager();
         $em->remove($reclamation);
         $em->flush();

            return $this->redirectToRoute ('aff');
       }
       #[Route('/Ajout2')]
    function Ajout2(ReclamationRepository $repo,Request $req){
        $reclamation=new Reclamation();
        $form=$this->createForm(ReclamationType::class,$reclamation)->add('Ajout',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
           $repo->add($reclamation,true);

          return $this->redirectToRoute ('aff');
        }
        return $this->render ('reclamation/Ajout.html.twig',['f'=>$form->createView()]);   
    }
    #[Route('/Ajoutreclamation',name:'ajoutreclamation')]
    function Ajout(ManagerRegistry $doctrine,Request $request){
        $reclamation=new Reclamation;
        $form=$this->createFormBuilder($reclamation)
        ->add('datereclamation')
        ->add('contenu')
        //->add('etat', ChoiceType::class, [ 'choices' => [ 'passé', 'encour', 'expidié' , ], ])
        ->add('iduser')
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('aff');
        }
        return $this->render('reclamation/Ajout.html.twig',['f'=>$form->createView()]);
        
      }
      #[Route('/Update/{id}',name:'update')]
      function update(ManagerRegistry $doctrine ,Reclamation $reclamation,Request $req){
          $form=$this->createForm(ReclamationType::class,$reclamation)->add('Update',SubmitType::class);
          $form->handleRequest($req);
          if($form->isSubmitted() && $form->isValid()){ 
          $em=$doctrine->getManager();
          $em->flush();
  
            return $this->redirectToRoute ('aff');
          }
          return $this->render ('reclamation/Ajout.html.twig',['f'=>$form->createView()]);   
      }

}
