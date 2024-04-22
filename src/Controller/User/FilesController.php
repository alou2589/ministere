<?php

namespace App\Controller\User;


use App\Repository\FichiersAgentRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeAgentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/user/files')]
class FilesController extends AbstractController
{
    #[Route('/', name: 'app_user_files')]
    public function index(MessagesRepository $messagesRepository, FichiersAgentRepository $fichiersAgentRepository,TypeAgentRepository $typeAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('user/files/index.html.twig', [
            'fichiersAgents'=>$fichiersAgentRepository->findBy(['statut_agent'=>$this->getUser()->getAffectation()->getStatutAgent()]),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
