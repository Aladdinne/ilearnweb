<?php

namespace App\Form;

use App\Entity\Cour;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('ajout',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
