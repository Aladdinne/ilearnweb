<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CommentaireRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;


class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }


   // ajout 
   #[Route('/Ajoutcom',name: 'non')]
   function Ajoutcom(ManagerRegistry $doctrine,Request $request){
       $commentaire=new Commentaire();
      $form = $this->createForm(CommentaireType::class,$commentaire);
      
       
       $form->handleRequest(($request));
       if($form->isSubmitted() && $form->isValid() ){
           $em=$doctrine->getManager();
           $em->persist($commentaire);
           $em->flush();
           return $this->redirectToRoute('affcom');
       }
       return $this->render('commentaire/ajoutcom.html.twig',
       ['ajoutcomm'=>$form->createView()]);

   }

    // affichage
    #[Route('/Affichecom',name: 'affcom')]
    function Affiche(ManagerRegistry $doctrine){

        $commentaire=$doctrine->getRepository(Commentaire::class)->findAll();
        
        
        return $this->render('commentaire/affichcom.html.twig',['xx'=>$commentaire]);
    }

    //delete
    #[Route('/Deletecom/{id}', name:'dlcom')]
    function Delete(ManagerRegistry $doctrine,Commentaire $commentaire)
        {
            $em=$doctrine->getManager();
            $em->remove($commentaire);
            $em->flush();
            return $this->redirectToRoute('affcom');
        }

    //modifier

        #[Route('/editcomm/{id}', name:'edcom')]
        function editercom(ManagerRegistry $doctrine,Request $request,Commentaire $commentaire){

            if (!$commentaire) {


                $commentaire=new Commentaire();

            }


          
            $form=$this->createFormBuilder($commentaire)
            ->add('contentcommentaire', TextType::class, [
                'label' => 'Contenu'])
            ->add('emailcommentaire', EmailType::class, [
                'label' => 'Votre e-mail'])
            ->add('nickname', TextType::class, [
                'label' => 'Nickname'])
           // ->add('createdAt')
            ->add('rgpd', CheckboxType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
                ->add('Modifier', SubmitType::class)
                ->getForm();
           
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid() ){
                $em=$doctrine->getManager();
                $em->persist($commentaire);
                $em->flush();
                return $this->redirectToRoute('affcom');
            }
            return $this->render('commentaire/ajoutcom.html.twig',
            ['ajoutcomm'=>$form->createView()]);

        }

}
