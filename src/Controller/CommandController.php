<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\CommandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CommandController extends AbstractController
{
    #[Route('/command', name: 'app_command')]
    function Affiche (CommandRepository $rep ){
        $command = new Command();
        $command = $rep->findall();
        return $this->render('command/Affiche.html.twig',['cc'=>$command]);
    }
    #[Route('/Affichec',name:'ff')]
    function Affiches (CommandRepository $rep ){
        $command = new Command();
        $command = $rep->findall();
        return $this->render('command/Affiche.html.twig',['cc'=>$command]);
    }
}
