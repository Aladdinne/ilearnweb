<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Form\CourType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;






class CourController extends AbstractController
{
    #[Route('/cour', name: 'app_cour')]
    public function index(): Response
    {
        return $this->render('cour/listcour2.html.twig', [
            'controller_name' => 'CourController',
        ]);
    }

    #[Route('/listcour/{idf}', name: 'listcour')]
    public function listcour(ManagerRegistry $doctrine, $idf){
        $cours = $doctrine ->getRepository(Cour::class)->findBy(['idformation'=>$idf]);
        return $this->render("cour/listcour.html.twig", array('listcour'=>$cours,'idd'=>$idf));



    }

    //add
    #[Route('/addcour/{id}', name: 'addcour')]
    public function addcour(Request $request, ManagerRegistry $doctrine,$id)
    {
        $cour = new Cour();
        $form = $this->createForm(CourType::class,$cour);

        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em ->persist($cour);
            $em ->flush();
            $this ->addFlash('success',"Cour ".$cour->getNomcour()."a été ajouté avec succés");
            return $this->redirectToRoute('listcour',['idf'=>$id]);

        }

        return $this->render("cour/addcour.html.twig",['FormCour'=>$form->createView()]);
    }


    //delete
    #[Route('/deletecour/{id}/{idd}', name:'deletecour')]
    public function Deletecour(ManagerRegistry $doctrine, Cour $cour= null,$idd):RedirectResponse
    {
        if($cour){

            $em=$doctrine->getManager();
            $em->remove($cour);
            $em->flush();
            $this->addFlash('success',"Cour ".$cour->getNomcour()." a été supprimé");}
        else {
            $this->addFlash('error',"Cour n'existe plus");
        }
        return $this->redirectToRoute('listcour',['idf'=>$idd]);
    }


    ///client
    #[Route('/listcourC/{idf}', name: 'listcourC')]
    public function listcourC(ManagerRegistry $doctrine, $idf){
        $cours = $doctrine ->getRepository(Cour::class)->findBy(['idformation'=>$idf]);
        return $this->render("cour/clientcour.html.twig", array('listcourC'=>$cours));



    }


    // update
    #[Route('/updatecour/{id}/{idd}', name:'updatecour')]
    public function updatecour (ManagerRegistry $doctrine, Request $request, Cour $cour,$idd)
    {
        if(!$cour){
            $cour = new Cour();

        }
        $form = $this ->createFormBuilder($cour)
            ->add('nomcour', TextType::class, [
                'label' => 'Nom Cour'])
            ->add('nomformateur', TextType::class, [
                'label' => 'Nom Formateur'])
            ->add('pdf',UrlType::class, [
                'label' => 'Lien pdf'])
            ->add('video', UrlType::class, [
                'label' => 'Lien video'])
            ->add('idformation')


            ->add('Modifier', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($cour);
            $em->flush();
            $this->addFlash('success',"Cour ".$cour->getNomcour()." a été modifié");
            return $this->redirectToRoute('listcour',['idf'=>$idd]);
        }
        return $this->render("cour/addcour.html.Twig",['FormCour'=>$form->createView()]);

    }

}
