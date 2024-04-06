<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RecipeController extends AbstractController
{
    /**
     * The above function is a PHP controller method that takes a request, a slug, and an ID as
     * parameters and then dumps the slug and ID for debugging purposes.
     * 
     * @param Request request The `` parameter in the `index` method is an instance of the
     * `Symfony\Component\HttpFoundation\Request` class. It represents the current HTTP request and
     * contains information such as the request method, headers, query parameters, request body, etc.
     * @param string slug The slug parameter in the route represents a part of the URL that identifies
     * a specific resource. In this case, the slug is expected to contain lowercase letters, numbers,
     * and hyphens. It is used for creating SEO-friendly URLs and improving the readability of the web
     * address.
     * @param int id The "id" parameter in the route corresponds to the unique identifier of the
     * recipe. It is expected to be an integer value as specified by the requirement 'id' => '\d+'.
     */


    #[Route('/recette', name: 'recipe.list')]
    public function list(Request $request): Response
   {
       return new Response('Liste des recettes', Response::HTTP_OK);
   }

   
    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function index(Request $request, string $slug, int $id): Response
    {
        dd($slug, $id);
    }
    
}