<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'mainNavAdmin' => true,
            'title' => 'Espace Admin'
        ]);
    }
}
