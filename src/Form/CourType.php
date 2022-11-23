<?php

namespace App\Form;

use App\Entity\Cour;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomcour', TextType::class, [
            'label' => 'Nom Cour'])
            ->add('nomformateur', TextType::class, [
                'label' => 'Nom Formateur'])
            ->add('pdf',UrlType::class, [
                'label' => 'Lien pdf'])
            ->add('video', UrlType::class, [
                'label' => 'Lien video'])
            ->add('idformation')
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
