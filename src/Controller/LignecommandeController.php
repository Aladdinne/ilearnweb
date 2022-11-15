<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Entity\Command;
use App\Entity\Formation;
use App\Entity\User;
use App\Repository\LignecommandeRepository;
use App\Repository\FormationRepository;
use App\Repository\CommandRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
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
      #[Route('/DeleteLignecommande/{id}', name:'removeLigne')]
    function delete(ManagerRegistry $doctrine,Lignecommande $lignecommande){
        $em=$doctrine->getManager();
        $em->remove($lignecommande);
        $em->flush();
        return $this->redirectToRoute('fff');
    }
}
