<?php

namespace App\Controller\Admin;

use App\Entity\Maintenance;
use App\Form\MaintenanceType;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MaintenanceRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/maintenance')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class MaintenanceController extends AbstractController
{
    #[Route('/', name: 'app_admin_maintenance_index', methods: ['GET'])]
    public function index(MaintenanceRepository $maintenanceRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/maintenance/index.html.twig', [
            'maintenances' => $maintenanceRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_maintenance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $maintenance = new Maintenance();
        $form = $this->createForm(MaintenanceType::class, $maintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maintenance);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/maintenance/new.html.twig', [
            'maintenance' => $maintenance,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_maintenance_show', methods: ['GET'])]
    public function show(Maintenance $maintenance,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/maintenance/show.html.twig', [
            'maintenance' => $maintenance,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_maintenance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maintenance $maintenance, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(MaintenanceType::class, $maintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_maintenance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/maintenance/edit.html.twig', [
            'maintenance' => $maintenance,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_maintenance_delete', methods: ['POST'])]
    public function delete(Request $request, Maintenance $maintenance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maintenance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($maintenance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_maintenance_index', [], Response::HTTP_SEE_OTHER);
    }
}
