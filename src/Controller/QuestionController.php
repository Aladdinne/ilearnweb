<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Devoir;
use App\Form\CommandType;
use App\Repository\DevoirRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/questioni', name: 'app_questioni')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    // back office

    #[Route('/question/{id}', name: 'app_question')]
    function Affiche (QuestionRepository $rep ,$id){
         $question = $rep->findBy(Array('iddevoir'=>$id));
        return $this->render('question/Affiche.html.twig',['cc'=>$question,'idd'=>$id]);
    }

    #[Route('/Ajoutquestion/{id}',name:'ajoutquestion')]
    function Ajout(ManagerRegistry $doctrine,Request $request,$id,DevoirRepository $rep){
        $question=new Question;
        $form=$this->createFormBuilder($question)
            ->add('numquestion')
            ->add('contenu')
            ->add('reponse')
            ->add('point')
            ->add('Ajout',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $devoir=$rep->findOneBy(Array('iddevoir'=>$id));
            $question->setIddevoir($devoir);

            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('app_question',['id'=>$id]);
        }
        return $this->render('question/Ajout.html.twig',['ff'=>$form->createView()]);

    }

    #[Route('question/Update/{id}', name:'questionUpdate')]
    function Update(ManagerRegistry $doctrine,Question $question,Request $req,$id){
        $form=$this->createFormBuilder($question)
            ->add('numquestion')
            ->add('contenu')
            ->add('reponse')
            ->add('point')
            ->add('Update',SubmitType::class)
            ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_question',['id'=>$id]);
        }
        return $this->render('question/Ajout.html.twig',['ff'=>$form->createView()]);
    }

    #[Route('question/Delete/{id}', name:'questionremove')]
    function delete(ManagerRegistry $doctrine,Question $question,$id){
        $em=$doctrine->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('app_question',['id'=>$id]);
    }


    //front office

    #[Route('/question2/{id}', name: 'app_question2')]
    function Affiche2 (QuestionRepository $rep ,$id){
        $question = $rep->findBy(Array('iddevoir'=>$id));
        return $this->render('question/Affiche2.html.twig',['cc'=>$question,'idd'=>$id]);
    }

}
