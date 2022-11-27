<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Entity\Command;
use App\Entity\Formation;
use App\Entity\User;
use App\Repository\LignecommandeRepository;
use App\Repository\FormationRepository;
use App\Repository\CommandRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class LignecommandeController extends AbstractController
{
    
    #[Route('/lignecommande', name: 'app_lignecommande')]
    public function index(): Response
    {
        return $this->render('lignecommande/index.html.twig', [
            'controller_name' => 'LignecommandeController',
        ]);
    }
    #[Route('/AfficheLigne/{id}',name:'fc')]
    function Affiches (LignecommandeRepository $rep ,FormationRepository $repp,CommandRepository $reep,$id){
        $lignecommande = new Lignecommande();
        $command = new Command();
        $formation = new Formation();
        $command = $reep->findall();
        $lignecommande = $rep->findBy(array('idcommand'=>$id));
        $formation = $repp->findAll();
        return $this->render('lignecommande/Affiche.html.twig',['cm'=>$command,'ff'=>$formation,'ll'=>$lignecommande]);
    }
    #[Route('/AfficheLignee/{id}',name:'fcc')]
    function Affichess (LignecommandeRepository $rep ,FormationRepository $repp,CommandRepository $reep,$id){
        $lignecommande = new Lignecommande();
        $command = new Command();
        $formation = new Formation();
        $command = $reep->findall();
        $lignecommande = $rep->findBy(array('idcommand'=>$id));
        $formation = $repp->findAll();
        return $this->render('lignecommande/Afficheclient.html.twig',['cm'=>$command,'ff'=>$formation,'ll'=>$lignecommande]);
    }
    #[Route('/Update/{id}', name:'Update')]
      function Update(ManagerRegistry $doctrine,Command $lignecommande,Request $req){
        $form=$this->createForm(CommandType::class,$lignecommande)
        ->add('Update',SubmitType::class);       
    $form->handleRequest($req);
    if($form->isSubmitted() && $form->isValid()){
        $em=$doctrine->getManager();
        $em->flush();
    return $this->redirectToRoute('ffs');
    }
    return $this->render('command/Ajout.html.twig',['ff'=>$form->createView()]);
      }
      #[Route('/DeleteLignecommande/{id}/{idc}', name:'removeLigne')]
    function delete(ManagerRegistry $doctrine,Lignecommande $lignecommande,$id,$idc){
        $em=$doctrine->getManager();
        $em->remove($lignecommande);
        $em->flush();
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $sql="UPDATE `command` SET  `total` = (SELECT SUM(prix) FROM lignecommande WHERE idcommand = $idc) WHERE `command`.`idcommand` =$idc ;";
        $smt = $pdo->query($sql);
        
        return $this->redirectToRoute('fcc',array('id'=> $idc));
    }
    

   /* public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }*/
    
    
    #[Route('/Add/{id}', name:'addl')]
    function add($id,SessionInterface $session){
       /* $session = $this->requestStack->getSession();*/
        $panier = $session->get('panier',[]);
            
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $sqll =  "SELECT MAX(idcommand)  FROM command ;";
        $stm = $pdo->query($sqll);
        $idc= $stm->fetch();
        $sql ="INSERT INTO `lignecommande` (`idlignecommand`, `idcommand`, `idformation`, `prix`) VALUES (NULL,( SELECT MAX(idcommand)  FROM command ), $id, (SELECT prix FROM formation WHERE idformation=$id));";
        
        
        if(!empty($panier[$id])){
            
            $panier[$id] = 1;
            
            
        }else{
            $panier[$id] = 1;
            $smt = $pdo->query($sql);
            
        }
        $session->set('panier',$panier);
        /*dd($session->get('panier'));*/
        return $this->redirectToRoute ('fmn');
        
    }
    #[Route('/panier',name:'pan-cart')]
    public function panier(SessionInterface $session,FormationRepository $formationRepository){
        $panier = $session->get('panier',[]);
        $panierWithData = [];
        
        foreach($panier as $id =>$quantity){
            $panierWithData[] = [ 'product' => $formationRepository->find($id),
                                   'qunatity' =>$quantity
        ];
                
        }
        $total=0;
        foreach($panierWithData as $item){
            $totalItem = $item['product']->getPrix();
            $total += $totalItem;
        }
       //dd($panierWithData);
        return $this->render('lignecommande/elem.html.twig', ['items' => $panierWithData,'total' => $total]);
    }

    #[Route('/Removepanier/{id}', name:'removepanier')]
    public function remove ($id,SessionInterface $session){
        $panier = $session->get('panier',[]);
        $pdo =  new PDO('mysql:host=localhost;dbname=ilearn;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $sqld=("DELETE FROM `lignecommande` WHERE idcommand = ( SELECT MAX(idcommand)  FROM lignecommande ) AND idformation = $id");
        if(!empty($panier[$id])){
            
            unset($panier[$id]);
            $smt = $pdo->query($sqld);
        }
        
        $session->set('panier',$panier);

        return $this->redirectToRoute("pan-cart");
    }

    
}
