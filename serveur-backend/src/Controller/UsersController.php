<?php

namespace App\Controller;

use App\Entity\TpaUsers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users', name: 'app_users')]
class UsersController extends AbstractController
{
    #[Route('/register', name: 'app_users')]
    public function index(Request $request, EntityManagerInterface $em) //: JsonResponse
    {
        $user = new TpaUsers();
        // $user->setEmail($request=>email)
    }

    #[Route('/admin', name: 'app_users_admin')]
    public function admin(): Response
    {
        $this->denyAccessUnlessGranted('role@user');
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
