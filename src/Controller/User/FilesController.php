<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AbstractController
{
    #[Route('/user/files', name: 'app_user_files')]
    public function index(): Response
    {
        return $this->render('user/files/index.html.twig', [
            'controller_name' => 'FilesController',
        ]);
    }
}
