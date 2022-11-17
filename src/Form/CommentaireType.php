<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('parentId')
            ->add('contentcommentaire', TextType::class, [
                'label' => 'Contenu'])
            ->add('emailcommentaire', EmailType::class, [
                'label' => 'Votre e-mail'])
            ->add('nickname', TextType::class, [
                'label' => 'Nickname'])
           // ->add('createdAt')
            ->add('rgpd', CheckboxType::class, ['label' => 'je ne suis pas un robot'
                //'constraints' => [
                  //  new NotBlank()
               // ]
            ])

           
            ->add('envoyer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
