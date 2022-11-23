<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceValue;
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
    function AjoutArticle(ManagerRegistry $doctrine,Request $request,UserRepository $repo){
        $user = new User();
        $user = $repo->findAll();
        $article=new Article();
        $form=$this->createFormBuilder($article)->add('nomarticle')
        ->add('idcreateur')
        //->add('idcreateur',EntityType::class,['class'=>User::class,'choice_label'=>'iduser',])
        //->add('datecreation')
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
        $form=$this->createFormBuilder($article)->add('etatarticle',ChoiceType::class,['choices' => ['non_traité','accepté','refusée',],])
        //>add('idarticle')
        //->add('nomarticle')
        //->add('idcreateur')
        //->add('datecreation')
        //->add('contenu')
        ->add('Modifier',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('Affichearticle');
        }
        return $this->render('article/modifierarcadmin.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/Articleaccepte')]
    public function Articleaccepter(ArticleRepository $rep){
        $article = new Article();
        $etatarticle='accepté';
        $article = $rep->articleaccepte($etatarticle);
        return $this->render('article/articleaccepte.html.twig',['arc'=>$article]);

    }
}
