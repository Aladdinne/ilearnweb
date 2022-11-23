<?php

namespace App\Controller;


use App\Entity\Formation;

use App\Form\FormationType;
use App\Form\FormationUpdateType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    #[Route('/listformation', name: 'listformation')]
    public function listformation(ManagerRegistry $doctrine){
        $formations = $doctrine ->getRepository(Formation::class)->findAll();
        return $this->render("formation/listformation.html.twig", array('listformation'=>$formations));
    }
    //add
    #[Route('/addformation', name: 'addformation')]
    public function addformation(Request $request, ManagerRegistry $doctrine)
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class,$formation);
        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em ->persist($formation);
            $em ->flush();
            $this ->addFlash('success',"Formation ".$formation->getNomformation()."a été ajouté avec succés");
            return $this->redirectToRoute('listformation');
        }

        return $this->render("formation/addformation.html.twig",['FormFormation'=>$form->createView()]);

    }

    //delete
    #[Route('/deleteformation/{id}', name:'deleteformation')]
    public function Deleteformation(ManagerRegistry $doctrine,Formation $formation= null):RedirectResponse
    {
        if($formation){

        $em=$doctrine->getManager();
        $em->remove($formation);
        $em->flush();
        $this->addFlash('success',"Formation ".$formation->getNomformation()." a été supprimé");}
        else {
        $this->addFlash('error',"Formation n'existe plus");
        }
        return $this->redirectToRoute('listformation');
    }

    // update
    #[Route('/updateformation/{id}', name:'updateformation')]
    public function updateformation (ManagerRegistry $doctrine, Request $request, Formation $formation)
    {
        if(!$formation){
           $formation = new Formation();

        }
        $form = $this ->createFormBuilder($formation)
        ->add('nomformation', TextType::class, [
        'label' => 'Nom formation'])

        ->add('description', TextType::class, [
            'label' => 'Description'])

        ->add('datecreation', DateType::class, [
            'label' => 'Date de création'])

        ->add('duree',TextType::class ,[
            'label' => 'Durée',
            'help' =>  '  Durée est sous la forme  Heures:Minutes:Secondes',])

        ->add('category', choiceType::class, [
                'choices'  => [
                    'it'=>'it',
                    'math'=>'math',
                    'physics'=>'physics',],])

        ->add('prix', MoneyType::class,[
            'label' => 'Prix'])

        ->add('Modifier', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($formation);
            $em->flush();
            $this->addFlash('success',"Formation ".$formation->getNomformation()." a été modifié");
            return $this->redirectToRoute('listformation');
        }
        return $this->render("formation/addformation.html.twig",['FormFormation'=>$form->createView()]);

    }

    #[Route('/listfcl', name: 'listformationclient')]
    public function listformationCl(ManagerRegistry $doctrine){
        $formations = $doctrine ->getRepository(Formation::class)->findAll();
        return $this->render("formation/clientf.html.twig", array('listf'=>$formations));
    }
}
