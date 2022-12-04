<?php

namespace App\Controller;

use App\Entity\Cour;
use App\Form\CourType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\Annotations\ParamEncryptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Handler\DownloadHandler;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;


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
    #[ParamDecryptor(["idf"])]
    public function listcour(ManagerRegistry $doctrine, $idf){
        $cours = $doctrine ->getRepository(Cour::class)->findBy(['idformation'=>$idf]);
        return $this->render("cour/listcour.html.twig", array('listcour'=>$cours,'idd'=>$idf));



    }

    //add cour
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


    //delete cour
    #[Route('/deletecour/{idcour}/{iddel}', name:'deletecour')]
    public function Deletecour(ManagerRegistry $doctrine, Cour $cour= null,$iddel):RedirectResponse
    {
        if($cour){

            $em=$doctrine->getManager();
            $em->remove($cour);
            $em->flush();
            $this->addFlash('success',"Cour ".$cour->getNomcour()." a été supprimé");}
        else {
            $this->addFlash('error',"Cour n'existe plus");
        }
        return $this->redirectToRoute('listcour',['idf'=>$iddel]);
    }


    ///client affichage
    #[Route('/listcourC/{idf}', name: 'listcourC')]
    #[ParamDecryptor(["idf"])]
    public function listcourC(ManagerRegistry $doctrine, $idf, Request $request, PaginatorInterface $paginator){
        $cours = $doctrine ->getRepository(Cour::class)->findBy(['idformation'=>$idf]);
        $cours= $paginator->paginate(
            $cours, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );
        return $this->render("cour/clientcour.html.twig", array('listcourC'=>$cours));



    }


    // update
    #[Route('/updatecour/{id}/{idd}', name:'updatecour')]
    #[ParamDecryptor(["id"])]
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

            ->add('pdfFile',VichFileType::class, [
                'label' => ' pdf',
                'required' => false,
                'download_uri' => true,
            ])

            ->add('imageFile', VichImageType::class, [
                'label' => 'Image cour',
                'required' => false,
                'image_uri' => true,
            ])

            ->add('idformation')
            ->add("recaptcha", ReCaptchaType::class)
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

    ///telechargement pdf

    #[Route('/courPdf/{idcour}', name:'courPdf')]

    public function downloadpdf( DownloadHandler $downloadHandler,Cour $cour ): Response
    {

        return $downloadHandler->downloadObject($cour, 'pdfFile');

    }




}
