<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\EvenementRepository;
use App\Entity\Evenement;
use App\Form\EvenementType;
use Symfony\Component\HttpFoundation\Request;

use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\Persistence\ManagerRegistry;


class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    // ajout 
    #[Route('/Ajoutevnm',name: 'yes')]
            function Ajout(ManagerRegistry $doctrine,Request $request){
                $evenement=new Evenement();
               $form = $this->createForm(EvenementType::class,$evenement);
               
                
                $form->handleRequest(($request));
                if($form->isSubmitted() && $form->isValid() ){
                    $em=$doctrine->getManager();
                    $em->persist($evenement);
                    $em->flush();
                   return $this->redirectToRoute('affevnm');
                   $this->addFlash('message', 'Votre commentaire a bien été envoyé');

                }
                return $this->render('evenement/ajoutev.html.twig',
                ['ajoutevn'=>$form->createView()]);

            }

            // affichage
    #[Route('/Afficheevn',name: 'affevnm')]
    function Affiche(ManagerRegistry $doctrine){

        $evenement=$doctrine->getRepository(Evenement::class)->findAll();
        
        
        return $this->render('evenement/afficheevn.html.twig',['afevn'=>$evenement]);
    }

    //delete
    #[Route('/Deleteev/{id}', name:'dlev')]
    function Delete(ManagerRegistry $doctrine,Evenement $evenement)
        {
            $em=$doctrine->getManager();
            $em->remove($evenement);
            $em->flush();
            return $this->redirectToRoute('affevnm');
        }

    //modifier

        #[Route('/editevn/{id}', name:'edev')]
        function editer3(ManagerRegistry $doctrine,Request $request,Evenement  $evenement){

            if (!$evenement) {


                $evenement=new Evenement();

            }


          
            $form=$this->createFormBuilder($evenement)
            ->add('nomEvenement', TextType::class, [
                'label' => 'Type événement'])
            ->add('sujetev', TextType::class, [
                'label' => 'Sujet événement'])
            
            
            ->add('nomcreateurev', TextType::class, [
                'label' => 'créateur dévènement'])
                ->add('lieuev', TextType::class, [
                    'label' => 'Lieu'])
                ->add('dateev', DateType::class, [
                    'label' => 'Date'])
            ->add('heureev', TimeType::class, [
                'label' => 'Heure'])
                ->add('Modifier', SubmitType::class)
                ->getForm();
           
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid() ){
                $em=$doctrine->getManager();
                $em->persist($evenement);
                $em->flush();
                return $this->redirectToRoute('affevnm');
            }
            return $this->render('evenement/ajoutev.html.twig',
            ['ajoutevn'=>$form->createView()]);

        }



}
