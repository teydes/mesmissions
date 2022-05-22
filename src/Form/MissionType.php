<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Veuilez entrez le nom'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Veuilez entrez la description'
            ])
            ->add('link', TextType::class, [
                'label' => 'Veuilez entrez le lien'
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Veuilez entrez l\'image',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
            'translation_domain' => 'forms'
        ]);
    }
}
