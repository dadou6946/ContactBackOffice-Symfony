<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /** Page d'accueil
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }
}