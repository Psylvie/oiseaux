<?php

namespace App\Form;

use App\Entity\Oiseau;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class OiseauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [ 'label'=>'Espece: ',])
            ->add('imageFile', VichImageType::class,[
                'label'=>"Photo de l'oiseau: ",
                'required'=>true,
            ])
            ->add('sexe')
            ->add('habitat')
            ->add('alimentation')
            ->add('lieux')
            ->add('taille')
            ->add('longevite')
            ->add('reproduction')
            ->add('couleur')
            ->add('description')
            ->add('prix')
//            ->add('user',EntityType::class, [
//                'class'=>User::class,
//                'attr'=>['data-mask']
//
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oiseau::class,
        ]);
    }
}
