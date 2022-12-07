<?php

namespace App\Controller;

use App\Entity\Categoryrec;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\CategoryrecType;
use App\Repository\CategoryrecRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\PieChart\PieSlice;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryrecController extends AbstractController
{
    #[Route('/categoryrec', name: 'app_categoryrec')]
    public function index(): Response
    {
        return $this->render('categoryrec/index.html.twig', [
            'controller_name' => 'CategoryrecController',
        ]);
    }
    
    #[Route('/Affichecateg',name:'aff1')]
    function Affichecateg(CategoryrecRepository $repo,UserRepository $repp,ReclamationRepository $rep1){
        $categoryrec = new Categoryrec();
        $user=new User();
        $reclamation=new Reclamation();
        $categoryrec=$repo->findAll();
        $user=$repp->findAll();
        $reclamation=$rep1->findAll();
        return $this->render('categoryrec/Affichercategoryrec.html.twig',
       ['cc'=>$categoryrec,'ff'=>$user,'rr'=>$reclamation]);
    }
    #[Route('/Affiche2',name:'affic')]
    function Affiche(ManagerRegistry $doctrine){
        $categoryrec=$doctrine->getRepository(Categoryrec::class)->findAll();
        return $this->render('categoryrec/Affichercategoryrec2.html.twig',
       ['kk'=>$categoryrec]);
    }
    #[Route('/Deleteca/{id}',name:'DD1')]
    function Deleteca(ManagerRegistry $doctrine ,Categoryrec $categoryrec){
     $em=$doctrine->getManager();
     $em->remove($categoryrec);
     $em->flush();

        return $this->redirectToRoute ('aff1');
   }
   #[Route('/Deleteca1/{id}',name:'DD12')]
    function Deletecaclient(ManagerRegistry $doctrine ,Categoryrec $categoryrec){
     $em=$doctrine->getManager();
     $em->remove($categoryrec);
     $em->flush();

        return $this->redirectToRoute ('affic');
   }
  /*#[Route('/Ajoutcate2')]
   function Ajoutcate2(CategoryrecRepository $repo1,Request $reque):Response {
       $categoryrec=new Categoryrec();
       $form=$this->createForm(CategoryrecType::class,$categoryrec)->add('Ajout',SubmitType::class);
       $form->handleRequest($reque);
       if($form->isSubmitted() && $form->isValid()){
          $repo1->add($categoryrec,true);

         return $this->redirectToRoute ('affic');
       }
       return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);   
   }*/
   #[Route('/Ajout3',name:'ajoutcateg')]
   function Ajout(ManagerRegistry $doctrine,Request $request){
       $categoryrec=new Categoryrec();
       $form=$this->createFormBuilder($categoryrec)->add('category',ChoiceType::class, [ 'choices' => [ 'avis', 'feeeedback', 'rapport' ,'autre' ], ])->add('Ajout',SubmitType::class)->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em=$doctrine->getManager();
           $em->persist($categoryrec);
           $em->flush();

           return $this->redirectToRoute ('ajoutreclamation');
       }
     return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);
   }
   #[Route('/Update1/{id}',name:'update1')]
      function update(ManagerRegistry $doctrine ,Categoryrec $categoryrec,Request $req){
          $form=$this->createForm(CategoryrecType::class,$categoryrec)->add('Update',SubmitType::class);
          $form->handleRequest($req);
          if($form->isSubmitted() && $form->isValid()){ 
          $em=$doctrine->getManager();
          $em->flush();
  
            return $this->redirectToRoute ('affic');
          }
          return $this->render ('categoryrec/Ajoutcategoryrec.html.twig',['ff'=>$form->createView()]);   
        }

      #[Route('/statistiquecategory',name:'statis1')]
    
        public function statistiqueuser(CategoryrecRepository $rep){
            $navis=0;
            $nfeedback=0;
            $nrapport=0;
            $nautre =0;
            $items= new Categoryrec();
            $items = $rep->findAll();
            foreach($items as $item){
                if($item->getCategory()=='avis'){
                    $navis=$navis+1;
                }elseif ($item->getCategory()=='feeeedback') {
                    $nfeedback=$nfeedback+1;
                }elseif ($item->getCategory()=='rapport') {
                   $nrapport=$nrapport+1;
                }else {
                    $nautre=$nautre+1;

                }
            }
            $pieChart = new PieChart();
            $pieChart->getData()->setArrayToDataTable(
            [
                ['Pac Man', 'Percentage'],
                ['avis', $navis],
                ['feeeedback', $nfeedback],
                ['rapport', $nrapport],
                ['autre', $nautre]
            ]
            );
            $pieChart->getOptions()->setTitle('le nombre de reclamation en pourcentage');
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
            return $this->render('categoryrec/statistique.html.twig',array('pieChart' => $pieChart));
        }
}
