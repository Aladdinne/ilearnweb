<?php

namespace App\Controller;

//include './vendor/autoload.php';

use App\Entity\Rendezvous;
use App\Entity\User;
use App\Form\RendezvousType;
use App\Form\RendezvoussType;
use App\Repository\UserRepository;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Twilio\Rest\Client;
use function PHPSTORM_META\type;

class RendezvousController extends AbstractController
{
    #[Route('/rendezvous', name: 'app_rendezvous')]
    public function index(): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'controller_name' => 'RendezvousController',
        ]);
    }
    #[Route('/AfficheRendezvous',name:'ffr')]
    function Affiche (SessionInterface $session,RendezvousRepository $rep,UserRepository $repp ){
        $user = $repp->findAll();
        $auth = $session->get('auth',[]);
        $id = $auth->getIduser();
        $rendezvous = $rep->findall();
        return $this->render('rendezvous/Affiche1.html.twig',['rr'=>$rendezvous,'cc'=>$user,'ii'=>$id]);
    }
    #[Route('/AfficheRendezvouss',name:'fffr')]
    function Affiche1 (RendezvousRepository $rep,UserRepository $repp ){
        $user = $repp->findAll();
        $rendezvous = $rep->findall();
        return $this->render('rendezvous/Affiche.html.twig',['rrr'=>$rendezvous,'ccc'=>$user]);
    }
    #[Route('/Ajoutrendezvous',name:'ajoutrendezvous')]
    function Ajout(SessionInterface $session,ManagerRegistry $doctrine,Request $request){
        $rendezvous=new Rendezvous;
        $auth = $session->get('auth',[]);
        $user=new User;
        $form=$this->createFormBuilder($rendezvous)
            ->add('daterdv')
            ->add('dureerdv')
            ->add('tel')
            ->add('motif')
           // ->add('idclient') 
            ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sid    = "AC40a2bf2c3b42a8ca159c39d88298e173"; 
            $token  = "5cd0d08a1668034921f512ba9d316c75"; 
            $twilio = new Client($sid, $token); 
     
            $twilio->messages 
                      ->create("+21692108297", 
                               array("from" => "+14302492629",    
                                   "body" => "Votre demande a été traitée" 
                               ) 
                      ); 
           $rendezvous->setIdclient($auth->getIduser());
            $em=$doctrine->getManager();
            $em->persist($rendezvous);
            $em->flush();
            return $this->redirectToRoute('ffr');
        }
        /* 
       
 
        //print($message->sid);*/
        return $this->render('rendezvous/Ajoutrdv.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Deleterdv/{id}', name:'removerdv')]
    function delete(ManagerRegistry $doctrine,Rendezvous $rendezvous){
        $em=$doctrine->getManager();
        $em->remove($rendezvous);
        $em->flush();
        return $this->redirectToRoute('ffr');
    }
    #[Route('/Updaterdv/{id}', name:'Updaterdv')]
    function Update(ManagerRegistry $doctrine,Rendezvous $rendezvous,Request $req){
      $form=$this->createForm(RendezvousType::class,$rendezvous)
      ->add('Update',SubmitType::class);       
  $form->handleRequest($req);
  if($form->isSubmitted() && $form->isValid()){
      $em=$doctrine->getManager();
      $em->flush();
  return $this->redirectToRoute('ffr');
  }
  return $this->render('rendezvous/Ajoutrdv.html.twig',['ff'=>$form->createView()]);
    }
    #[Route('/Updaterdvv/{id}', name:'Updaterdvv')]
    function Updatee(ManagerRegistry $doctrine,Rendezvous $rendezvous,Request $req){
      $form=$this->createForm(RendezvoussType::class,$rendezvous)
      ->add('Update',SubmitType::class) ; 

  $form->handleRequest($req);
  if($form->isSubmitted() && $form->isValid()){
      $em=$doctrine->getManager();
      $em->flush();
  return $this->redirectToRoute('fffr');
  }
  return $this->render('rendezvous/Ajoutrdvv.html.twig',['ff'=>$form->createView()]);
    }
    #[Route('/searchRendezVous', name:'searchRendervous')]
    public function searchStudentx(Request $request,NormalizerInterface $Normalizer,RendezvousRepository $sr)
    {
        $repository = $this->getDoctrine()->getRepository(Rendezvous::class);
        $requestString=$request->get('searchValue');
        $rendezvous = $sr->findRendezVousByDaterdv($requestString);
        $jsonContent = $Normalizer->normalize($rendezvous,'json',['groups'=> 'rendezvous']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

}
