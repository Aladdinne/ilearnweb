<?php

namespace App\Form;

use App\Entity\Formation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomformation',TextType::class, [
                'label' => 'Nom formation'])
            ->add('description', TextType::class, [
                'label' => 'Description'])
            ->add('datecreation', DateType::class, [
                'label' => 'Date de création'])
            ->add('duree',TextType::class,[
                'label' => 'Durée' ,
                'help' =>  ' Durée est sous la forme  Heures:Minutes:Secondes',])
            ->add('category', choiceType::class, [
                'choices'  => [
                    'it'=>'it',
                    'math'=>'math',
                    'physics'=>'physics',],])
            ->add('prix', MoneyType::class,[
                'label' => 'Prix'])
            ->add("recaptcha", ReCaptchaType::class)
            ->add('ajout',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
