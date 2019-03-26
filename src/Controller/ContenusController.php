<?php

namespace App\Controller;

use App\Entity\Contenus;
use App\Entity\User;
use App\Form\ContenusType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class ContenusController extends Controller
{
    /**
     * @Route("/contenus/new", name="contenus_new")
     */
    public function new(Request $request)
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

            return $this->redirect('../');

        }

        return $this->render('contenus/form.html.twig', [
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
     * @Route("/", name="contenus_view")
     */
    public function View(PaginatorInterface $paginator, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findAll();


        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $contenusAll,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)


        );


        return $this->render('contenus/view.html.twig', [
            'contenusAll' => $result,
        ]);
    }
}
