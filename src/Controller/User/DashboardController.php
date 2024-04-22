<?php

namespace App\Controller\User;

use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function index(MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('user/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
