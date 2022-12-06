<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Devoir;
use App\Form\CommandType;

use App\Repository\ReponseRepository;
use App\Repository\QuestionRepository;
use App\Repository\DevoirRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\Builder\BuilderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DevoirController extends AbstractController
{




    #[Route('/devoiri', name: 'app_devoiri')]
    public function index(): Response
    {
        return $this->render('devoir/index.html.twig', [
            'controller_name' => 'DevoirController',
        ]);
    }
    #[Route('/devoir', name: 'app_devoir')]
    function Affiche (DevoirRepository $rep,ChartBuilderInterface $chartBuilder ){

        $it=0;
        $math=0;
        $physic=0;

        $queryresults=$rep->countcategorydevoir();
        if($queryresults[0]['categ']=="it")$it=$queryresults[0]['counting'];
        if($queryresults[1]['categ']=="math")$math=$queryresults[1]['counting'];
        if($queryresults[2]['categ']=="physic")$physic=$queryresults[2]['counting'];

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [
                ['Pac Man', 'Percentage'],
                ['it', $it],
                ['physic', $physic],
                ['math', $math]
            ]
        );
        $pieChart->getOptions()->setTitle('le pourcentage de devoir par category');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $pieSlice1 = new PieSlice();
        //$pieSlice1->getOptions()->setTitle('Admin');
        $pieSlice1->setColor('yellow');
        $pieSlice2 = new PieSlice();
        $pieSlice2->setColor('red');
        $pieSlice3 = new PieSlice();
        $pieSlice3->setColor('blue');

        $pieSlice4 = new PieSlice();
        $pieSlice4->setColor('green');
        $pieChart->getOptions()->setSlices([$pieSlice1, $pieSlice2,$pieSlice3,$pieSlice4]);

        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTooltip()->setTrigger('none');

        $Devoir = $rep->findall();
        return $this->render('devoir/Affiche.html.twig',['cc'=>$Devoir,'pieChart' => $pieChart]);
    }

    #[Route('/Ajoutdevoir',name:'ajoutdevoir')]
    function Ajout(ManagerRegistry $doctrine,Request $request){
        $devoir=new Devoir;
        $form=$this->createFormBuilder($devoir)
            ->add('namedevoir')
            ->add('dureedevoir')
            ->add('datecreation')
            ->add('contenu')
            ->add('category', ChoiceType::class, [ 'choices' => [ 'it', 'math', 'physic' , ], ])
            ->add('Ajout',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->persist($devoir);
            $em->flush();
            return $this->redirectToRoute('app_devoir');
        }
        return $this->render('devoir/Ajout.html.twig',['ff'=>$form->createView()]);

    }

    #[Route('devoir/Update/{id}', name:'devoirUpdate')]
    function Update(ManagerRegistry $doctrine,Devoir $devoir,Request $req){
        $form=$this->createFormBuilder($devoir)
            ->add('namedevoir')
            ->add('dureedevoir')
            ->add('datecreation')
            ->add('contenu')
            ->add('category', ChoiceType::class, [ 'choices' => [ 'it', 'math', 'physic' , ], ])
            ->add('Update',SubmitType::class)
            ->getForm();
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_devoir');
        }
        return $this->render('devoir/Ajout.html.twig',['ff'=>$form->createView()]);
    }

    #[Route('devoir/Delete/{id}', name:'devoirremove')]
    function delete(ManagerRegistry $doctrine,Devoir $devoir){
        $em=$doctrine->getManager();
        $em->remove($devoir);
        $em->flush();
        return $this->redirectToRoute('app_devoir');
    }

    //--------------------------------------------------------------------------------------------------------------
    // ------------------------front office-------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------

    #[Route('/devoir2', name: 'app_devoir2')]
    function Affiche2 (DevoirRepository $rep ){

        $Devoir = $rep->findall();
        return $this->render('devoir/Affiche2.html.twig',['cc'=>$Devoir]);
    }

    //#[Route('devoir/resultat/{id}', name:'resultatdevoir')]
    #[Route('devoir/resultat/{id}', name:'resultatdevoir',methods:"GET")]
    function resultatdevoir(BuilderInterface $qrbuilder,DevoirRepository $rep,SessionInterface $session,$id){
        $resultat=0;
        $auth = $session->get('auth',[]);
        $iid =$auth->getIduser();
        $array=$rep->resultat($id,$iid);
        foreach ($array as $value){
            $resultat+=$value['note'];
        }
        $qrresult=$qrbuilder->size(100)->margin(2)->data($resultat)->build();
        $qrresult->saveToFile((\dirname(__DIR__,2).'/public/assets/qrcode'.'.png'));
        $output=strval($resultat);

        return $this->render('devoir/resultat.html.twig',['resultat'=>$output]);
    }

    #[Route('devoir/search/', name:'searchdevoir')]
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $devoir =  $em->getRepository('App\Entity\Devoir')->findEntitiesByString($requestString);

        if(!$devoir) {
            $result['devoir']['error'] = "nothing found";
        } else {
            $result['devoir'] = $this->getRealEntities($devoir);
        }

        return new Response(json_encode($result));
    }

    public function getRealEntities($devoir){

        foreach ($devoir as $dev){
            $realEntities[$dev->getIddevoir()] =[ $dev->getNamedevoir()];
        }

        return $realEntities;
    }
}
