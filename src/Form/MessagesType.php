<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
                [   'label'=>'Titre: ',
                    'attr'=> [
                    'class'=>'form-control',

                ]])
            ->add('message', TextareaType::class, [
                'label'=>'Message: ',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('recipient', EntityType::class, [
                'label'=>'Destinataire: ',
                'class'=> User::class,
                'choice_label'=>'pseudo',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('envoyer', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn_primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
