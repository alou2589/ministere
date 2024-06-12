<?php

namespace App\Controller\Admin;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Repository\NotificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/notification')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class NotificationController extends AbstractController
{
    #[Route('/', name: 'app_admin_notification_index', methods: ['GET'])]
    public function index(NotificationRepository $notificationRepository): Response
    {
        return $this->render('admin/notification/index.html.twig', [
            'notifications' => $notificationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_notification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NotificationRepository $notificationRepository): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationRepository->save($notification, true);

            return $this->redirectToRoute('app_admin_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/notification/new.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_notification_show', methods: ['GET'])]
    public function show(Notification $notification): Response
    {
        return $this->render('admin/notification/show.html.twig', [
            'notification' => $notification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_notification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Notification $notification, NotificationRepository $notificationRepository): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationRepository->save($notification, true);

            return $this->redirectToRoute('app_admin_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/notification/edit.html.twig', [
            'notification' => $notification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_notification_delete', methods: ['POST'])]
    public function delete(Request $request, Notification $notification, NotificationRepository $notificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $notificationRepository->remove($notification, true);
        }

        return $this->redirectToRoute('app_admin_notification_index', [], Response::HTTP_SEE_OTHER);
    }
}
