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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
