<?php

namespace App\Controller;

use App\Entity\Contenus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class MemberController extends Controller
{
    /**
     * @Route("/member", name="member_index")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findAll();

        return $this->render('member/index.html.twig', [
            'mainNavMember' => true,
            'title' => 'Espace Membre',
            'contenusAll' => $contenusAll,
        ]);
    }


}
