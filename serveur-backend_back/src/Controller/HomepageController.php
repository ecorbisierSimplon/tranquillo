<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomepageController extends AbstractController
{
    #[Route('/api')]
    public function index(): String
    {
        return "Hello";
        // return $this->render('homepage/index.html.twig', [
        //     'controller_name' => 'HomepageController',
        // ]);
    }
}
