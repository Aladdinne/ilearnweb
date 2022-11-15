<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    #[Route('/AfficheArticle',name:'Affichearticle')]
    public function afficheArticle(ArticleRepository $rep){
        $article=new Article();
        $article = $rep->findAll();
        return $this->render('affichearticle.html.twig',['arc'=>$article]);
    }
    #[Route('/DeleteArticle/{id}',name:'Deletearticle')]
    function Delete(ManagerRegistry $doctrine ,Article $article){
        $em=$doctrine->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('Affichearticle');
    }
    #[Route('/Ajoutearticle')]
    function AjoutArticle(ManagerRegistry $doctrine,Request $request){
        $article=new Article();
        $form=$this->createFormBuilder($article)->add('nomarticle')
        ->add('idcreateur')
        ->add('datecreation')
        ->add('contenu')
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($article);
            $em->flush();
        }
        return $this->render('Ajoute.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/Modifierarticle/{id}',name:'modifierarticle')]
    function ModifierArticle(ManagerRegistry $doctrine,Request $request,Article $article){
        $form=$this->createFormBuilder($article)->add('nomarticle')
        ->add('idcreateur')
        ->add('datecreation')
        ->add('contenu')
        ->add('etatarticle',ChoiceType::class,['choices' => ['non_traité','accepté','refusée',],])
        ->add('Modifier',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('Affichearticle');
        }
        return $this->render('Ajoute.html.twig',['f'=>$form->createView()]);

    }
    
}
