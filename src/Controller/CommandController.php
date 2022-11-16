<?php

namespace App\Controller;

use App\Entity\Command;
use App\Form\CommandType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\UserRepository;
use App\Repository\CommandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class CommandController extends AbstractController
{
    #[Route('/command', name: 'app_command')]
    function Affiche (CommandRepository $rep ){
        $command = new Command();
        $command = $rep->findall();
        return $this->render('command/Affiche.html.twig',['cc'=>$command]);
    }
    #[Route('/Affichec',name:'ffs')]
    function Affiches (CommandRepository $rep ,UserRepository $repp){
        $command = new Command();
        $user = new User();
        $command = $rep->findall();
        $user = $repp->findAll();
        return $this->render('command/Affiche.html.twig',['cc'=>$command,'uu'=>$user]);
    }
    #[Route('/Afficheco',name:'fff')]
    function Affichesc (CommandRepository $rep ,UserRepository $repp){
        $command = new Command();
        $user = new User();
        $command = $rep->findall();
        $user = $repp->findAll();
        return $this->render('command/Afficheclient.html.twig',['cc'=>$command,'uu'=>$user]);
    }
    #[Route('/Delete/{id}', name:'removee')]
    function delete(ManagerRegistry $doctrine,Command $command){
        $em=$doctrine->getManager();
        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('fff');
    }
    #[Route('/DeleteCommande/{id}', name:'removeCommande')]
    function delete1(ManagerRegistry $doctrine,Command $command){
        $em=$doctrine->getManager();
        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('ffs');
    }
    #[Route('/Ajoutcommand',name:'ajoutcommand')]
    function Ajout(ManagerRegistry $doctrine,Request $request){
        $command=new Command;
        $form=$this->createFormBuilder($command)
        ->add('datecommand')
        ->add('total')
        ->add('etat', ChoiceType::class, [ 'choices' => [ 'passé', 'encour', 'expidié' , ], ])
        ->add('iduser')
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($command);
            $em->flush();
            return $this->redirectToRoute('ffs');
        }
        return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Ajoutcommandd',name:'ajoutcommandd')]
    function Ajoutt(ManagerRegistry $doctrine,Request $request){
        $command=new Command;
        $form=$this->createFormBuilder($command)
        ->add('datecommand')
        ->add('total')
        ->add('etat', ChoiceType::class, [ 'choices' => [ 'passé', 'encour', 'expidié' , ], ])
        ->add('iduser')
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($command);
            $em->flush();
            return $this->redirectToRoute('fff');
        }
        return $this->render('command/Ajoutclient.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Update/{id}', name:'Updatee')]
      function Update(ManagerRegistry $doctrine,Command $command,Request $req){
        $form=$this->createForm(CommandType::class,$command)
        ->add('Update',SubmitType::class);       
    $form->handleRequest($req);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->flush();
    return $this->redirectToRoute('ffs');
    }
    return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
      }
  
    }

