<?php

namespace App\Controller;

use App\Entity\Videos;
use App\Form\VideoType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class VideosController extends Controller
{
    /**
     * @Route("/contenus/new/video", name="video_new")
     */
    public function newVideo(Request $request)
    {

        $contenus = new Videos();
        $contenus->setDate(new \DateTime('now'));
        $contenus->setAuteur($this->getUser()->getUsername());

        $form = $this->createForm(VideoType::class, $contenus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect('/videos');

        }

        return $this->render('contenus/formImage.html.twig', [
            'formContenu' => $form->createView(),
        ]);
    }

    /**
     * @Route("/videos", name="videos_view")
     */
    public function ViewVideo(PaginatorInterface $paginator, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Videos::class);
        $videosAll = $repository->findBy(
            array(),
            array('date'=>'DESC')
        );


        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $videosAll,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('contenus/video.html.twig', [
            'videosAll' => $result,
        ]);
    }
}
