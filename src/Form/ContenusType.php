<?php

namespace App\Form;

use App\Entity\Contenus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Titre de l\'image', 'attr' => ['class' => 'form-control']])
            ->add('file', FileType::class, ['label' => 'Image', 'attr' => ['class' => 'form-control-file']])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter', 'attr' => ['class' => 'btn btn-dark mt-3']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contenus::class,
        ]);
    }
}
