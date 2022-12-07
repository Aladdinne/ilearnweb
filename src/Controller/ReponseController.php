<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    #[Route('/reponsei', name: 'app_reponsei')]
    public function index(): Response
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }

    //back office

    #[Route('/reponse/{id}', name: 'app_reponse')]
    function Affiche (ReponseRepository $rep ,$id){
        $reponse = $rep->findBy(Array('idquestion'=>$id));
        return $this->render('reponse/Affiche.html.twig',['cc'=>$reponse,'idd'=>$id]);
    }



    #[Route('reponse/Update/{id}/{idd}', name:'reponseUpdate')]
    function Update(ManagerRegistry $doctrine,Reponse $reponse,Request $req,$idd){
        $form=$this->createFormBuilder($reponse)
            ->add('note')
            ->add('etat',ChoiceType::class, [ 'choices' => [ true,false  ], ])
            ->add('Update',SubmitType::class)
            ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_reponse',['id'=>$idd]);
        }
        return $this->render('reponse/Ajout.html.twig',['ff'=>$form->createView()]);
    }

    //front office
    #[Route('/reponse2/{id}', name: 'app_reponse2')]
    function Affiche2 (ReponseRepository $rep ,$id){
        $reponse = $rep->findBy(Array('idquestion'=>$id));
        return $this->render('reponse/Affiche2.html.twig',['cc'=>$reponse,'idd'=>$id]);
    }

    #[Route('/Ajoutreponse2/{id}',name:'ajoutreponse2')]
    function Ajout(ManagerRegistry $doctrine,Request $request,$id,QuestionRepository $rep){
        $reponse=new Reponse;
        $form=$this->createFormBuilder($reponse)
            ->add('contenu')
            ->add('Ajout',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $question=$rep->findOneBy(Array('idquestion'=>$id));
            $reponse->setIdquestion($question);
            $em->persist($reponse);
            $em->flush();
            return $this->redirectToRoute('app_reponse2',['id'=>$id]);
        }
        return $this->render('reponse/Ajout.html.twig',['ff'=>$form->createView()]);

    }

    #[Route('reponse2Update/{id}/{idd}', name:'reponseUpdate2')]
    function Update2(ManagerRegistry $doctrine,Reponse $reponse,Request $req,$idd){
        $form=$this->createFormBuilder($reponse)
            ->add('note')
            ->add('etat',ChoiceType::class, [ 'choices' => [ true,false  ], ])
            ->add('Update',SubmitType::class)
            ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_reponse2',['id'=>$idd]);
        }
        return $this->render('reponse/Ajout.html.twig',['ff'=>$form->createView()]);
    }


}
