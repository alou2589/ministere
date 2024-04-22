<?php

namespace App\Controller\User;

use App\Repository\AttributionRepository;
use App\Repository\CategorieMaterielRepository;
use App\Repository\MaintenanceRepository;
use App\Repository\MaterielRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/myparc')]
class MyParcController extends AbstractController
{
    #[Route('/', name: 'app_user_myparc')]
    public function index(MessagesRepository $messagesRepository, MaintenanceRepository $maintenanceRepository,AttributionRepository $attributionRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('user/my_parc/index.html.twig', [
            'maintenances'=>$maintenanceRepository->findAll(),
            'materiels' => $attributionRepository->findBy(['affectation'=>$this->getUser()->getAffectation()]),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
