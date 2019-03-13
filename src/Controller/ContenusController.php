<?php

namespace App\Controller;

use App\Entity\Contenus;
use App\Form\ContenusType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContenusController extends Controller
{
    /**
     * @Route("/contenus/new", name="contenus_new")
     */
    public function new(Request $request)
    {

        $contenus = new Contenus();

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
                //afficher message erreur si ça bug
            }

            $contenus->setFile($fileStoreName);

            $entity = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect('new');
        }

        return $this->render('contenus/form.html.twig', [
            'form' => $form->createView(),
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
     * @Route("/contenus", name="contenus_view")
     */
    public function View()
    {
        $repository = $this->getDoctrine()->getRepository(Contenus::class);
        $contenusAll = $repository->findAll();


        return $this->render('contenus/view.html.twig', [
            'contenusAll' => $contenusAll,
        ]);
    }
}
