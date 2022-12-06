<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        /*
            ->add('nomEvenement')
            ->add('sujetev')
            ->add('dateev')
            ->add('heureev')
            ->add('lieuev')
            ->add('nomcreateurev')
        ;
*/

        ->add('nomEvenement', TextType::class, [
            'label' => 'Type événement'])
        ->add('sujetev', TextType::class, [
            'label' => 'Sujet événement'])
        
        
        ->add('nomcreateurev', TextType::class, [
            'label' => 'créateur dévènement'])
            ->add('lieuev', TextType::class, [
                'label' => 'Lieu'])
            ->add('dateev', DateType::class, [
                'label' => 'Date'])
        ->add('heureev', TimeType::class, [
            'label' => 'Heure'])
        ->add('Ajout', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
