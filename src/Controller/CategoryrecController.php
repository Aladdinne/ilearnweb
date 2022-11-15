<?php

namespace App\Controller;

use App\Entity\Categoryrec;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\CategoryrecType;
use App\Repository\CategoryrecRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryrecController extends AbstractController
{
    #[Route('/categoryrec', name: 'app_categoryrec')]
    public function index(): Response
    {
        return $this->render('categoryrec/index.html.twig', [
            'controller_name' => 'CategoryrecController',
        ]);
    }
    /*#[Route('/Affichecateg',name:'aff1')]
    function Affichecateg(CategoryrecRepository $repo,UserRepository $repp,ReclamationRepository $rep1){
        $categoryrec = new Categoryrec();
        $user=new User();
        $reclamation=new Reclamation();
        $categoryrec=$repo->findAll();
        $user=$repp->findAll();
        $reclamation=$rep1->findAll();
        return $this->render('categoryrec/Affichercategoryrec.html.twig',
       ['cc'=>$categoryrec,'ff'=>$user,'rr'=>$reclamation]);
    }*/
    #[Route('/Affiche2',name:'affic')]
    function Affiche(ManagerRegistry $doctrine){
        $categoryrec=$doctrine->getRepository(Categoryrec::class)->findAll();
        return $this->render('categoryrec/Affichercategoryrec2.html.twig',
       ['kk'=>$categoryrec]);
    }
    #[Route('/Deleteca/{id}',name:'DD1')]
    function Deleteca(ManagerRegistry $doctrine ,Categoryrec $categoryrec){
     $em=$doctrine->getManager();
     $em->remove($categoryrec);
     $em->flush();

        return $this->redirectToRoute ('aff1');
   }
   #[Route('/Deleteca1/{id}',name:'DD12')]
    function Deletecaclient(ManagerRegistry $doctrine ,Categoryrec $categoryrec){
     $em=$doctrine->getManager();
     $em->remove($categoryrec);
     $em->flush();

        return $this->redirectToRoute ('affic');
   }
  /* #[Route('/Ajoutcate2')]
   function Ajout2(CategoryrecRepository $repo,Request $req){
       $categoryrec=new Categoryrec();
       $form=$this->createForm(CategoryrecType::class,$categoryrec)->add('Ajout',SubmitType::class);
       $form->handleRequest($req);
       if($form->isSubmitted() && $form->isValid()){
          $repo->add($categoryrec,true);

         return $this->redirectToRoute ('affic');
       }
       return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);   
   }*/
   #[Route('/Ajout3')]
   function Ajout(ManagerRegistry $doctrine,Request $request){
       $categoryrec=new Categoryrec();
       $form=$this->createFormBuilder($categoryrec)->add('category',ChoiceType::class, [ 'choices' => [ 'avis', 'feeeedback', 'rapport' ,'autre' ], ])->add('Ajout',SubmitType::class)->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em=$doctrine->getManager();
           $em->persist($categoryrec);
           $em->flush();

           return $this->redirectToRoute ('affic');
       }
     return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);
   }
   #[Route('/Update1/{id}',name:'update1')]
      function update(ManagerRegistry $doctrine ,Categoryrec $categoryrec,Request $req){
          $form=$this->createForm(CategoryrecType::class,$categoryrec)->add('Update',SubmitType::class);
          $form->handleRequest($req);
          if($form->isSubmitted() && $form->isValid()){ 
          $em=$doctrine->getManager();
          $em->flush();
  
            return $this->redirectToRoute ('affic');
          }
          return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);   
      }
}
