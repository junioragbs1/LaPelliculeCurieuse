<?php

namespace App\Form;

use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutSeriesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre' , TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Votre titre doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre titre ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
            ])
            ->add('description',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 210,
                        'minMessage' => 'Votre description doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre desciption ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
            ])
            ->add('genre', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Votre genre doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre genre ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
            ])
            ->add('dateDeSortie')
            ->add('duree')
            ->add('realisateurs', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Votre titre doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre titre ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
            ])
            ->add('affiche', FileType::class, [
                'label' => 'Affiche de la série',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Merci d’ajouter une image JPG ou PNG',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
        ]);
    }
}
