<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FmnController extends AbstractController
{
    #[Route('/fmn', name: 'app_fmn')]
    public function index(): Response
    {
        return $this->render('fmn/index.html.twig', [
            'controller_name' => 'FmnController',
        ]);
    }
    #[Route('/Affichefmn',name:'fmn')]
    function Affichesc (FormationRepository $rep){
        $command = new Formation();
        $command = $rep->findall();
        return $this->render('fmn/Affichefmn.html.twig',['cc'=>$command]);
    }
}
