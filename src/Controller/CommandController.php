<?php

namespace App\Controller;

//use App\Controller\Pdfservice;
use App\Entity\Command;
use App\Form\CommandType;
use App\Entity\User;
//use App\Pdfservice;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\UserRepository;
use App\Repository\CommandRepository;
use ContainerIt87oxJ\getMercuryseriesFlashy_FlashyNotifierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use MpdfException;
use PHPUnit\TextUI\XmlConfiguration\Migration;
use PHPUnit\TextUI\XmlConfiguration\RemoveLogTypes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Config\MercuryseriesFlashyConfig;

class CommandController extends AbstractController
{
    #[Route('/command', name: 'app_command')]
    function Affiche (CommandRepository $rep ){
        $command = new Command();
        $command = $rep->findall();
        return $this->render('command/Affiche.html.twig',['cc'=>$command]);
    }
    #[Route('/Affichec',name:'ffs')]
    function Affiches (CommandRepository $rep ,UserRepository $repp){
        $command = new Command();
        $user = new User();
        $command = $rep->findall();
        $user = $repp->findAll();
        return $this->render('command/Affiche.html.twig',['cc'=>$command,'uu'=>$user]);
    }
    #[Route('/Afficheco',name:'fff')]
    function Affichesc (SessionInterface $session ,CommandRepository $rep ,UserRepository $repp){
        $auth = $session->get('auth',[]);
       // dd($session->get('auth'));
        $command = new Command();
        $user = new User();
        $id = $auth->getIduser();
        $command = $rep->findall();
        $user = $repp->findAll();
        return $this->render('command/Afficheclient.html.twig',['cc'=>$command,'uu'=>$user,'ii'=>$id]);
    }
    #[Route('/Delete/{id}', name:'removee')]
    function delete($id,ManagerRegistry $doctrine,Command $command){
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $sql=("DELETE FROM `lignecommande` WHERE idcommand = $id ");
        $smt = $pdo->query($sql);
        $em=$doctrine->getManager();
        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('fff');
    }
    #[Route('/DeleteCommande/{id}', name:'removeCommande')]
    function delete1($id,ManagerRegistry $doctrine,Command $command){
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $sql=("DELETE FROM `lignecommande` WHERE idcommand = $id ");
        $smt = $pdo->query($sql);
        $em=$doctrine->getManager();
        $em->remove($command);
        $em->flush();
        return $this->redirectToRoute('ffs');
    }
    #[Route('/Ajoutcommand',name:'ajoutcommand')]
    function Ajout(ManagerRegistry $doctrine,Request $request){
        $command=new Command;
        $form=$this->createFormBuilder($command)
        ->add('datecommand')
        ->add('total')
        /*->add('etat', ChoiceType::class, [ 'choices' => [ 'passé', 'encour', 'expidié' , ], ])*/
        ->add('iduser',EntityType::class, [
            'class' => User::class,
            'choice_label' => 'iduser',
        ])
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($command);
            $em->flush();
            return $this->redirectToRoute('ffs');
        }
        return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Ajoutcommandd',name:'ajoutcommandd')]
    function Ajoutt(ManagerRegistry $doctrine,Request $request){
        $command=new Command;
        $form=$this->createFormBuilder($command)
        ->add('datecommand')
        ->add('total')
        ->add('etat', ChoiceType::class, [ 'choices' => [ 'passé', 'encour', 'expidié' , ], ])
        ->add('iduser',EntityType::class, [
            'class' => User::class,
            'choice_label' => 'iduser',
        ])
        ->add('Ajout',SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($command);
            $em->flush();
            return $this->redirectToRoute('fff');
        }
        return $this->render('command/Ajoutclient.html.twig',['ff'=>$form->createView()]);
        
      }
      #[Route('/Update/{id}', name:'Updatee')]
      function Update(ManagerRegistry $doctrine,Command $command,Request $req){
        $form=$this->createForm(CommandType::class,$command)
        ->add('Update',SubmitType::class);       
    $form->handleRequest($req);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->flush();
    return $this->redirectToRoute('ffs');
    }
    return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
      }
      #[Route('/ValiderCommande/{id}', name:'validercommande')]
      function ValiderC(SessionInterface $session,FlashyNotifier $flashy){
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
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

            $mail->setFrom('aladin.hammouda@esprit.tn', 'Aladin Hammouda');//Your application NAME and EMAIL
            $mail->Subject = 'Commande bien ajouter';//Message subject
            //echo $request->request->get('nomA');
           // $mail->MsgHTML('bien créer');// Message body
            $mail->Body = '<h1>Votre Commande est valider . ' . '</h1>';

            $mail->addAddress('aladin.hammouda@esprit.tn', 'Aladin hammouda');// Target email


           $mail->send();
           $auth = $session->get('auth',[]);
        $id = $auth->getIduser();
        $sql="UPDATE `command` SET `iduser` = $id, `total` = (SELECT SUM(prix) FROM lignecommande WHERE idcommand = ( SELECT MAX(idcommand)  FROM command )),`datecommand`= NOW() WHERE `command`.`idcommand` = ( SELECT MAX(idcommand)  FROM command );";
        $smt = $pdo->query($sql);
        $sqll="INSERT INTO `command` (`idcommand`, `iduser`, `datecommand`, `total`, `etat`) VALUES (NULL, 1, NOW(), NULL, 'passé');";
        $smtt = $pdo->query($sqll);
        $flashy->success('Votre Commande est valider et un email a envoyer !', 'http://your-awesome-link.com');
        
        $session->remove('panier');
            
        return $this->redirectToRoute ('fff');
      }
      #[Route('/PdfCreate', name:'pdfcreate')]
      function pdf(Pdfservice $Pdf){
        $Pdf->Pdf();
        return $this->redirectToRoute ('fff');
      }
  
    }

