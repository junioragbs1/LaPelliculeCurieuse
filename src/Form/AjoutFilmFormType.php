<?php

namespace App\Form;

use App\Entity\Films;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AjoutFilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
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
                        'max' => 255,
                        'minMessage' => 'Votre description doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre desciption ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ]
            ])
            ->add('duree')
            ->add('dateDeSortie')
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
                'label' => 'Affiche du film (JPEG ou PNG)',
                'mapped' => false, // pas lié directement à l’entité
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci d’uploader une image JPG ou PNG',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Films::class,
        ]);
    }
}
