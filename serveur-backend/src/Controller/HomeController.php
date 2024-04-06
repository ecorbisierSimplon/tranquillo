<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/{name}', name: 'home')]
    public function index(Request $request, string $name): Response
    {
        // dd($request); // permet de visualiser le contenu request
        return new Response('Hello world ! ' . $name);
    }
}