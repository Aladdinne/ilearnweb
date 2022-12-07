<?php

namespace App\Controller;


use App\Entity\Cour;
use App\Entity\Formation;

use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Services\MailService;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Snappy\Pdf;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;

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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;



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
    #[Route('/deleteformation/{idformation}', name:'deleteformation')]
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
    #[Route('/updateformation/{idformation}', name:'updateformation')]
    #[ParamDecryptor(["idformation"])]
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
            ->add("recaptcha", ReCaptchaType::class)

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
///affichage du client
    #[Route('/listfcl', name: 'listformationclient')]
    public function listformationCl(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator){
        $formations = $doctrine ->getRepository(Formation::class)->findAll();
        $formations = $paginator->paginate(
            $formations, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render("formation/clientf.html.twig", array('listf'=>$formations));
    }





    ///mail
    #[Route('/formationmail', name:'formationmail')]
    public function mailformation(MailService $mailService,Request $request):Response
    {
        $mailname= $request->get('clemail');
        $mailcontent= $request->get('contentf');
        $mailService->sendEmail('khoualdia.mohamed@esprit.tn',$mailname,'Demande de renseignement',$mailcontent);
       return $this->redirectToRoute('listformationclient');

    }

    ///PDF
    #[Route('/pdf_download', name:'pdfFormation')]
    public function downloadPdf(Request $request,ManagerRegistry $doctrine,Pdf $snappy){

        $formation = $doctrine ->getRepository(Formation::class)->findAll();
        //$snappy=$this->get("knp_snappy.pdf");
        $html = $this->renderView("formation/pdf_formation.html.twig", array('listformation'=>$formation));
        $filename = "custom_pdf";
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'=>'application/pdf',
                'Content-Disposition'=>'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

//Recherche
    #[Route('/searchbyn}', name: 'searchbyn')]
    public function searchbyn(FormationRepository $repository, Request $request,PaginatorInterface $paginator){
        $motcle= $request->get('motcle');
        $formations=$repository->Searchbyn($motcle);
        $formations = $paginator->paginate(
            $formations, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/

        );
        return $this->render("formation/clientf.html.twig", array('listf'=>$formations));
    }
///admin
    #[Route('/listformationG', name: 'listformationG')]
    public function listformationAdmin(ManagerRegistry $doctrine){
        $formations = $doctrine ->getRepository(Formation::class)->findAll();
        return $this->render("formation/listformationG.html.twig", array('listformation'=>$formations));
    }






}
