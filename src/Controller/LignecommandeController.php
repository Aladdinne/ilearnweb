<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Repository\LignecommandeRepository;
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
    #[Route('/AfficheLigne',name:'fc')]
    function Affiche (LignecommandeRepository $rep ){
        $lignecommand = new Lignecommande();
        $lignecommande = $rep->findall();
        return $this->render('lignecommande/Affiche.html.twig',['cc'=>$lignecommande]);
    }
}
