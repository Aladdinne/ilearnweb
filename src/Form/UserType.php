<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD:src/Form/ReclamationType.php
           // ->add('datereclamation')
            ->add('contenu')
           // ->add('etatreclamation',ChoiceType::class, [ 'choices' => [ 'non-traite', 'traite' ] ,])
            //->add('iduser')
            ->add('captcha', ReCaptchaType::class)
            //->add('idcategory')
            //->add('enregistrer',SubmitType::class)
=======
            ->add('nom')
            ->add('username')
            ->add('userpwd')
            ->add('daten')
            ->add('email',EmailType::class)
            ->add('role',ChoiceType::class,['choices' => ['formateur'=>true,'etudiant'=>false,],])
<<<<<<< HEAD
>>>>>>> 078c388824bb1ea755dd5d30634ea302c0539f84:src/Form/UserType.php
=======
>>>>>>> refs/remotes/origin/main:src/Form/UserType.php
>>>>>>> main
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
