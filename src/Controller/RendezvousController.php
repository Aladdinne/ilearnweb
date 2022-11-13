<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class RendezvousController extends AbstractController
{
    #[Route('/rendezvous', name: 'app_rendezvous')]
    public function index(): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'controller_name' => 'RendezvousController',
        ]);
    }
    #[Route('/AfficheRendezvous',name:'ff')]
    function Affiche (RendezvousRepository $rep ){
        $rendezvous = $rep->findall();
        return $this->render('rendezvous/Affiche1.html.twig',['cc'=>$rendezvous]);
    }
}
