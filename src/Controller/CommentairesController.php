<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contenus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends Controller
{
    /**
     * @Route("/commentaires", name="commentaires")
     */
    public function commentView()
    {

        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $commentAll = $repository->findAll();

        return $this->render('commentaires/commentview.html.twig', [
            'contenusAll' => $contenusAll,
            'commentAll' => $commentAll,

        ]);
    }
}
