<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\films;
use App\Entity\Series;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutAvisFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('id_serie', EntityType::class, [
                'class' => Series::class,
                'choice_label' => 'titre',
                'required' => false,
            ])
            ->add('id_film', EntityType::class, [
                'class' => films::class,
                'choice_label' => 'titre',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
