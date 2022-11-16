<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/AfficheUser',name:'AfficheUser')]
    public function afficheUser(UserRepository $rep){
        $user = new User();
        $user = $rep->findAll();
        return $this->render('affiche.html.twig',['u'=>$user]);
    }
    #[Route('/DeleteUser/{id}',name:'Deleteuser')]
    function Delete(ManagerRegistry $doctrine ,User $user){
        $em=$doctrine->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('AfficheUser');
    }
    
    #[Route('/Ajouteuser',name:'ajouteuser')]
    function AjoutUser(ManagerRegistry $doctrine,Request $request){
        $user=new User();
        $form=$this->createFormBuilder($user)->add('nom')
        ->add('username')
        ->add('userpwd',PasswordType::class)
        ->add('daten')
        ->add('email')
        ->add('role',ChoiceType::class,['choices' => ['formateur','etudiant',],])
        ->add('Inscrire',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        $usera=$user;
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('AfficheUser',['u'=>$usera]);
        }
        return $this->render('user/Ajouteuser.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/Modifieruser/{id}',name:'modifieruser')]
    function ModifierArticle(ManagerRegistry $doctrine,Request $request,User $user){
        $form=$this->createFormBuilder($user)->add('nom')
        ->add('username')
        ->add('userpwd')
        ->add('daten')
        ->add('email')
        ->add('role',ChoiceType::class,['choices' => ['formateur','etudiant','admin',],])
        ->add('Modifier',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheUser');
        }
        return $this->render('user/AjouteuserAdmin.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/aj')]
    function AjoutUserAdmin(ManagerRegistry $doctrine,Request $request){
        $user=new User();
        $form=$this->createFormBuilder($user)->add('nom')
        ->add('username')
        ->add('userpwd',PasswordType::class)
        ->add('daten')
        ->add('email')
        ->add('role',ChoiceType::class,['choices' => ['formateur','etudiant','admin',],])
        ->add('Ajouter',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('AfficheUser');
        }
        return $this->render('user/AjouteuserAdmin.html.twig',['f'=>$form->createView()]);

    }
    /*
    #[Route('/Auth')]
    public function auth(Request $req,UserRepository $rep){
        $user = new User();
        $form=$this->createFormBuilder($user)->add('username')
        ->add('userpwd')
        ->add('Auth',SubmitType::class)
        ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user1= new User();
            $user1=$rep->RechercheUser($user->getUsername(),$user->getUserpwd());
            if(strcmp($user1->getRole(),"admin"){
                return $this->redirectToRoute('AfficheUser');
            }
        }
        return $this->render('user/auth.html.twig',['fo'=>$form->createView()]);
    }*/
}
