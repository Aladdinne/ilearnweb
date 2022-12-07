<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
=======
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
>>>>>>> refs/remotes/origin/main
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('indexs.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/Auth')]
    public function auth(Request $req,UserRepository $rep,SessionInterface $session){
        $user = new User();
        $user1= new User();
<<<<<<< HEAD
        $form=$this->createFormBuilder($user)->add('username')
        ->add('userpwd')
        ->add('Auth',SubmitType::class)
        ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user1=$rep->RechercheUser($user->getUsername(),$user->getUserpwd());
           $size = count($user1) ;
           if($size != 0){
            $auth = $session->get('auth',[]);
            $authWithData = [];
            $session->clear();
            $session->set('auth',$user1[0]);
            //dd($sesssionuserWithData);
            if($user1[0]->getRole() == 'admin'){
                return $this->render('user/iduser.html.twig',['user'=>$authWithData]);
            }elseif ($user1[0]->getRole() == 'formateur') {
                return $this->render('indexs.html.twig',['user'=>$authWithData]);
            }elseif ($user1[0]->getRole() == 'etudiant') {
                # code...
            }
           }else {
            echo '<script language="Javascript">
                alert ("The username you entered isn t connected to an account !!" )
                </script>';
           }
           
            
=======
        $form=$this->createFormBuilder($user)
            ->add('username')
            ->add('userpwd' ,TextType::class )
            ->add('Auth',SubmitType::class)
            ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user1=$rep->RechercheUser($user->getUsername(),$user->getUserpwd());
            $size = count($user1) ;
            if($size != 0){
                $auth = $session->get('auth',[]);
                $authWithData = [];
                $session->clear();
                $session->set('auth',$user1[0]);
                //dd($sesssionuserWithData);
                if($user1[0]->getRole() == 'admin'){
                    return $this->redirectToRoute('app_devoir',['user'=>$authWithData]);
                }elseif ($user1[0]->getRole() == 'formateur') {
                    return $this->redirectToRoute('app_devoir',['user'=>$authWithData]);
                }elseif ($user1[0]->getRole() == 'etudiant') {
                    return $this->redirectToRoute('app_devoir2',['user'=>$authWithData]);
                }
            }else {
                echo '<script language="Javascript">
                alert ("The username you entered isn t connected to an account !!" )
                </script>';
            }


>>>>>>> refs/remotes/origin/main
        }
        return $this->render('auth.html.twig',['fo'=>$form->createView()]);
    }
}
