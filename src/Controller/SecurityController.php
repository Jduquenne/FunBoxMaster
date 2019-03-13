<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // Crée erreur si il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // recupere le dernier user taper par l'utitlisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->get('form.factory')
            ->createNamedBuilder(null)
            ->add('_username', null, ['label' => 'Email', 'attr' => ['class' => 'form-control validate']])
            ->add('_password', PasswordType::class, ['label' => 'Mot de passe', 'attr' => ['class' => 'form-control validate']])
            ->add('ok', SubmitType::class, ['label' => 'Ok', 'attr' => ['class' => 'btn btn-dark']])
            ->getform();
        return $this->render('security/login.html.twig', [
            'mainNavLogin' => true, 'title' => 'Connexion',
            'loginForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/check", name="check")
     */
    public function check()
    {
        return new Response();
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return new Response();
    }
}
