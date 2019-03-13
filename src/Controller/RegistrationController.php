<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) On crée le form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        // 2) On fait une demande dans Data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) On encode le password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // on active par défaut
            $user->setIsActive(true);
            $user->addRole("ROLE_USER");
            // 4) On sauvegarde l'user dans la base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // Petit message pour confirmer l'inscription
            $this->addFlash('success', 'Votre compte à bien été enregistré');

        }

        return $this->render('registration/register.html.twig', ['registrationForm' => $form->createView(), 'mainNavRegistration' => true, 'title' => 'Inscription']);

    }
}
