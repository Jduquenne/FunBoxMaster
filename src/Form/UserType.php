<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('label' => 'Username', 'attr' => ['class' => 'form-control validate']))
            ->add('email', EmailType::class, array('label' => 'Email', 'attr' => ['class' => 'form-control validate']))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe', 'attr' => ['class' => 'form-control validate mb-3']),
                'second_options' => array('label' => 'Confirmation du mot de passe', 'attr' => ['class' => 'form-control validate']),
            ))
            ->add('imgProfil', FileType::class, ['label' => 'Photo de Profil', 'attr' => ['class' => 'form-control-file']])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-dark']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
