<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use MercurySeries\FlashyBundle\FlashyNotifier;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use PhpParser\Builder\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

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
    function AjoutUser(ManagerRegistry $doctrine,Request $request,UserRepository $rep,FlashyNotifier $flashy){
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
            $userv = new User();
            $userv = $rep->forgetpwd($user->getUsername(),$user->getEmail());
            $size =count($userv);
            if($size == 0){
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $mail = new PHPMailer(true);

            $mail->isSMTP();// Set mailer to use SMTP
            $mail->CharSet = "utf-8";// set charset to utf8
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->SMTPSecure = 'tls';// Enable TLS encryption, ssl also accepted

            $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
            $mail->Port = 587;// TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isHTML(true);// Set email format to HTML

            $mail->Username = 'aladin.hammouda@esprit.tn';// SMTP username
            $mail->Password = '213JMT6795';// SMTP password

            $mail->setFrom('benabdallah.jalel@esprit.tn', 'ILEARN');//Your application NAME and EMAIL
            $mail->Subject = 'Inscription ILEARN';//Message subject
            //echo $request->request->get('nomA');
           // $mail->MsgHTML('bien créer');// Message body
            $mail->Body = '<h1>Inscription avec success</h1>';

            $mail->addAddress($user->getEmail());// Target email


           $mail->send();
           $flashy->success('Inscription avec success !', 'http://your-awesome-link.com');
           // return $this->redirectToRoute('AfficheUser',['u'=>$usera]);
        }else{
            $flashy->error('User deja existe !', 'http://your-awesome-link.com');
        }
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
    function AjoutUserAdmin(ManagerRegistry $doctrine,Request $request,FlashyNotifier $flashy,UserRepository $rep){
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
            $userv = new User();
            $userv = $rep->forgetpwd($user->getUsername(),$user->getEmail());
            $size =count($userv);
            if($size == 0){
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $mail = new PHPMailer(true);

            $mail->isSMTP();// Set mailer to use SMTP
            $mail->CharSet = "utf-8";// set charset to utf8
            $mail->SMTPAuth = true;// Enable SMTP authentication
            $mail->SMTPSecure = 'tls';// Enable TLS encryption, ssl also accepted

            $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
            $mail->Port = 587;// TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isHTML(true);// Set email format to HTML

            $mail->Username = 'aladin.hammouda@esprit.tn';// SMTP username
            $mail->Password = '213JMT6795';// SMTP password

            $mail->setFrom('benabdallah.jalel@esprit.tn', 'ILEARN');//Your application NAME and EMAIL
            $mail->Subject = 'Inscription ILEARN';//Message subject
            //echo $request->request->get('nomA');
           // $mail->MsgHTML('bien créer');// Message body
            $mail->Body = '<h1>Inscription avec success</h1>';

            $mail->addAddress($user->getEmail());// Target email


           $mail->send();
           $flashy->success('Inscription avec success !', 'http://your-awesome-link.com');
           return $this->redirectToRoute('AfficheUser');
        }else{
            $flashy->error('User deja existe !', 'http://your-awesome-link.com');
        }
        }
        return $this->render('user/AjouteuserAdmin.html.twig',['f'=>$form->createView()]);

    }
    
    
    #[Route('/Auth')]
    public function auth(Request $req,UserRepository $rep,SessionInterface $session,FlashyNotifier $flashy){
    
        $user = new User();
        $user1= new User();
        $form=$this->createFormBuilder($user)->add('username')
        ->add('userpwd',PasswordType::class)
        ->add('Log_in',SubmitType::class)
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
            //$username = $auth->getUsername();
            //dd($sesssionuserWithData);
            if($user1[0]->getRole() == 'admin'){
                return $this->render('base.html.twig');
            }elseif ($user1[0]->getRole() == 'formateur') {
                return $this->render('indexs.html.twig',['user'=>$authWithData]);
            }elseif ($user1[0]->getRole() == 'etudiant') {
                # code...
            }
           }else {
            $flashy->error('You don t have Account!', 'http://your-awesome-link.com');
           }
           
            
            
        }
        return $this->render('user/auth.html.twig',['fo'=>$form->createView()]);
    }
    #[Route('/ForgetPwd',name:'forgetpwd')]
    public function forgetpwd(Request $req,UserRepository $rep,ManagerRegistry $doctrine,FlashyNotifier $flashy){
        $user = new User();
        $form=$this->createFormBuilder($user)->add('username',TextType::class)
        ->add('email',TextType::class)
        ->add('userpwd',PasswordType::class)
        ->add("captcha",ReCaptchaType::class)
        ->add('Save',SubmitType::class)
        ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user1 = new User();
            $user1 = $rep->forgetpwd($user->getUsername(),$user->getEmail());
            $size = count($user1);
            if($size !=0){
                $user1[0]->setUserpwd($user->getUserpwd());
                $em=$doctrine->getManager();
                $em->flush($user1[0]);
                $flashy->success('Your password is changed !!', 'http://your-awesome-link.com');

            }else {
                $flashy->error('The username and email you entered isn t connected to an account !!', 'http://your-awesome-link.com');
                
            }

        }
        return $this->render('user/forgetpwd.html.twig',['form'=>$form->createView()]);

    }
    #[Route('/searchuser',name:'searchuser')]
    public function searchuser(Request $request,NormalizerInterface $Normalizer,UserRepository $rep){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $requestString=$request->get('searchValue');
        $users = $rep->findUser($requestString);
        $jsonContent = $Normalizer->normalize($users,'json',['groups'=>'users']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }
    #[Route('/trier',name:'trie')]
    public function trier(UserRepository $rep){
        $user = new User();
        $user = $rep->trier();
        return $this->render('affiche.html.twig',['u'=>$user]);
    }
}
