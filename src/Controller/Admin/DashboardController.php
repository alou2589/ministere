<?php

namespace App\Controller\Admin;

use App\Repository\AgentRepository;
use App\Repository\MessagesRepository;
use App\Repository\StructureRepository;
use App\Repository\NotificationRepository;
use App\Repository\SousStructureRepository;
use App\Repository\TypeStructureRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TypeSousStructureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(NotificationRepository $notificationRepository,MessagesRepository $messagesRepository,AgentRepository $agentRepository, StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository, 
                        TypeStructureRepository $typeStructureRepository, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $agents = $agentRepository->findAll();
        $typeStructures = $typeStructureRepository->findAll();
        $typeSousStructures = $typeSousStructureRepository->findAll();
        $structures = $structureRepository->findAll();
        $sousStructures = $sousStructureRepository->findAll();
        return $this->render('admin/dashboard/index.html.twig', [
            'agents' => $agents,
            'structures' => $structures,
            'type_structures' => $typeStructures,
            'type_sous_structures' => $typeSousStructures,
            'sous_structures' => $sousStructures,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
