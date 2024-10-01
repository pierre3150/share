<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;


class UserController extends AbstractController
{
    #[Route('/liste_users', name: 'app_liste_users')]
    public function liste_users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/liste-users.html.twig', [
            'users' => $users
        ]);
    }
}
