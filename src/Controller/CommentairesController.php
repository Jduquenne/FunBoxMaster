<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contenus;
use App\Entity\Videos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class CommentairesController
 * @package App\Controller
 *
 * @Route("/commentaires")
 */
class CommentairesController extends Controller
{
    /**
     * @Route("/image/{id}", name="commentaires_image")
     */


    public function getImage($id)
    {

        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenu = $repository->findOneById($id);


        return $this->render('commentaires/commentimage.html.twig', [
            'contenu' => $contenu,
        ]);

    }
    /**
     * @Route("/video/{id}", name="commentaires_video")
     */


    public function getVideo($id)
    {

        $repository = $this->getDoctrine()->getRepository(Videos::class);
        $video = $repository->findOneById($id);


        return $this->render('commentaires/commentvideo.html.twig', [
            'video' => $video,
        ]);

    }
}
