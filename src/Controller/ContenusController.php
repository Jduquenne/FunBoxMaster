<?php

namespace App\Controller;

use App\Entity\Contenus;
use App\Entity\Videos;
use App\Form\ContenusType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ContenusController extends Controller
{


    /**
     * @Route("/contenus/new/image", name="image_new")
     */
    public function newImage(Request $request)
    {

        $contenus = new Contenus();
        $contenus->setDate(new \DateTime('now'));
        $contenus->setAuteur($this->getUser()->getUsername());


        $form = $this->createForm(ContenusType::class, $contenus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fileStore */
            $fileStore = $contenus->getFile();

            $fileStoreName = $this->generateUniqueFileName() . '.' . $fileStore->guessExtension();

            try {
                $fileStore->move(
                    $this->getParameter('file_directory'),
                    $fileStoreName
                );
            } catch (FileException $e) {
                $this->addFlash('fail', 'Bug !');
            }

            $contenus->setFile($fileStoreName);

            $entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect('../../');

        }

        return $this->render('contenus/formImage.html.twig', [
            'formContenu' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/images", name="images_view")
     */
    public function ViewImage(PaginatorInterface $paginator, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findBy(
            array(),
            array('date'=>'DESC')
        );


        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $contenusAll,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('contenus/image.html.twig', [
            'contenusAll' => $result,
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index1(PaginatorInterface $paginator, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findBy(
            array(),
            array('date'=>'DESC')
        );

        $paginator = $this->get('knp_paginator');
        $contenus = $paginator->paginate(
            $contenusAll,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        $repository = $this->getDoctrine()->getRepository(Videos::class);
        $videosAll = $repository->findBy(
            array(),
            array('date'=>'DESC')
        );

        $paginator = $this->get('knp_paginator');
        $videos = $paginator->paginate(
            $videosAll,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('contenus/index.html.twig', [
            'contenusAll' => $contenus,
            'videosAll' => $videos,
        ]);

    }



}
