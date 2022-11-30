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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    function AjoutArticle(ManagerRegistry $doctrine,Request $request,UserRepository $repo,SessionInterface $session){
        $user = new User();
        $user = $repo->findAll();
        $article=new Article();
        $form=$this->createFormBuilder($article)->add('nomarticle')
        //->add('idcreateur')
        //->add('idcreateur',EntityType::class,['class'=>User::class,'choice_label'=>'iduser',])
        //->add('datecreation')
        ->add('contenu')
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $auth = $session->get('auth',[]);
            $authWithData = [];
           dd($session->get('auth',[]));
            $article->setIdcreateur($auth->getIduser());
            $em=$doctrine->getManager();
            $em->persist($article);
            $em->flush();
        }
        return $this->render('Ajoute.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/Modifierarticle/{id}',name:'modifierarticle')]
    function ModifierArticle(ManagerRegistry $doctrine,Request $request,Article $article){
        $form=$this->createFormBuilder($article)//->add('etatarticle',ChoiceType::class,['choices' => ['non_traité','accepté','refusée',],])
        //>add('idarticle')
        ->add('nomarticle')
        //->add('idcreateur')
        //->add('datecreation')
        ->add('contenu')
        ->add('Modifier',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $article->setEtatarticle("non-traité");
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('mesarticles');
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
    #[Route('/accepterarticle/{id}',name:'accepterarticle')]
    public function acceptearticle(Article $article,ManagerRegistry $doctrine){
        $article->setEtatarticle("accepté");
        $em=$doctrine->getManager();
        $em->flush($article);
        return $this->redirectToRoute('Affichearticle');

    }
    #[Route('/refusearticle/{id}',name:'refusearticle')]
    public function refusearticle(Article $article,ManagerRegistry $doctrine){
        $article->setEtatarticle("refusée");
        $em=$doctrine->getManager();
        $em->flush($article);
        return $this->redirectToRoute('Affichearticle');

    }
    #[Route('/mesarticles',name:'mesarticles')]
    public function mesarticles(SessionInterface $session,ArticleRepository $rep){
        $auth = $session->get('auth',[]);
        $authWithData = [];
        $article = new Article();
        $article = $rep->mesarticles($auth->getIduser());
        return $this->render('article/mesarticles.html.twig',['article'=>$article]);
    }
    /*
    #[Route('/articlebyid')]
    public function articlebyid(ArticleRepository $rep,SessionInterface $session){
        $sessionuser = $session->getIduser();
        $article = $rep->find($sessionuser);


    }*/
}
