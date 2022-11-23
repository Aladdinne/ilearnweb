<?php

namespace App\Controller;

use App\Entity\Categoryrec;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\CategoryrecRepository;
use App\Repository\UserRepository;

use Doctrine\Persistence\ManagerRegistry;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    #[Route('/Affichereclamation2',name:'aff')]
        function Affiche2(ReclamationRepository $repo,UserRepository $repp){
            $reclamation = new Reclamation();
            $user = new User();
            $reclamation=$repo->findAll();
            $user=$repp->findAll();
            return $this->render('reclamation/Affichereclamation.html.twig',
           ['cc'=>$reclamation,'ff'=>$user]);
        }
        #[Route('/Affichereclamtionclient2',name:'aff12')]
        function Affiche3(ReclamationRepository $repo,UserRepository $repp){
            $reclamation = new Reclamation();
            $user = new User();
            $reclamation=$repo->findAll();
            $user=$repp->findAll();
            return $this->render('reclamation/Affichereclamationclient.html.twig',
           ['kk'=>$reclamation,'aa'=>$user]);
        }

        #[Route('/Delete/{id}',name:'DD')]
        function Delete(ManagerRegistry $doctrine ,Reclamation $reclamation){
         $em=$doctrine->getManager();
         $em->remove($reclamation);
         $em->flush();

            return $this->redirectToRoute ('aff');
       }
       #[Route('/Deletereclamation/{id}',name:'DD18')]
       function Deletereclamation(ManagerRegistry $doctrine ,Reclamation $reclamation){
        $em=$doctrine->getManager();
        $em->remove($reclamation);
        $em->flush();

           return $this->redirectToRoute ('aff12');
      }
       /*#[Route('/Ajout2')]
    function Ajout2(ReclamationRepository $repo,Request $req){
        $reclamation=new Reclamation();
        $form=$this->createForm(ReclamationType::class,$reclamation)->add('Ajout',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
           $repo->add($reclamation,true);

          return $this->redirectToRoute ('aff');
        }
        return $this->render ('reclamation/Ajout.html.twig',['f'=>$form->createView()]);   
    }*/
    ///////////////////////////////////////////////////////////
    #[Route('/Ajoutreclamation',name:'ajoutreclamation')]
    function Ajout(ManagerRegistry $doctrine,Request $request,CategoryrecRepository $repo,Recaptcha3Validator $recaptcha3Validator){
        $reclamation=new Reclamation;
        $form=$this->createFormBuilder($reclamation)
       // ->add('datereclamation')
        ->add('contenu')
        ->add('iduser')
        ->add('captcha', Recaptcha3Type::class, [
            'constraints' => new Recaptcha3(),
            'action_name' => 'homepage',
           // 'script_nonce_csp' => $reclamation,

            
        ])
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $reclamation->setIdcategory($this->getidtype($repo));
            $score = $recaptcha3Validator->getLastResponse()->getScore();
            $em->persist($reclamation);
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

            $mail->Username = 'wissem.hammouda@esprit.tn';// SMTP username
            $mail->Password = '213JMT5489';// SMTP password

            $mail->setFrom('wissem.hammouda@esprit.tn', 'Wissem Hammouda');//Your application NAME and EMAIL
            $mail->Subject = 'reclamation bien ajouter';//Message subject
            //echo $request->request->get('nomA');
           // $mail->MsgHTML('bien créer');// Message body
            $mail->Body = '<h1>Reclamation: ' . $reclamation->getContenu(). '</h1>';

            $mail->addAddress('wissem.hammouda@esprit.tn', 'Wissem hammouda');// Target email


           //$mail->send();
            return $this->redirectToRoute('aff12');
        }
        return $this->render('reclamation/Ajout.html.twig',['f'=>$form->createView()]);
        
      }
      ///////////////////////////////////////////////////////////////////////////////////////////////
      #[Route('/Update/{id}',name:'updatereclamationclient')]
      function update(ManagerRegistry $doctrine ,Reclamation $reclamation,Request $req){
          $form=$this->createForm(ReclamationType::class,$reclamation)->add('Update',SubmitType::class);
          $form->handleRequest($req);
          if($form->isSubmitted() && $form->isValid()){ 
          $em=$doctrine->getManager();
          $em->flush();
  
            return $this->redirectToRoute ('aff12');
          }
          return $this->render ('reclamation/Ajout.html.twig',['f'=>$form->createView()]);   
      }
      ////////////////////////////////////////////////////////////////////////////////////////////////////
      #[Route('/updateetatrec/{id}',name:'updatereclamationuser')]
    function Updateetatrec(ManagerRegistry $doctrine,Request $req,Reclamation $reclamation){
        //$reclamation=new Reclamation;
        $form=$this->createFormBuilder($reclamation)
       ->add('etatreclamation',ChoiceType::class, [ 'choices' => [ 'non-traite', 'traite' ] ,])
        ->add('Update',SubmitType::class)
        ->getForm();
          $form->handleRequest($req);
          if($form->isSubmitted() && $form->isValid()){ 
          $em=$doctrine->getManager();
          $em->flush();
          return $this->redirectToRoute ('aff');
          }
          return $this->render ('reclamation/Ajoutreclamadmin.html.twig',['f'=>$form->createView()]);   
        }


    function getidtype(CategoryrecRepository $repo){
        $reclamation=$repo->findAll();
        foreach ($reclamation as $reclamation){
            $id=$reclamation->getIdcategory();
        }
        return $id;
    }  

}