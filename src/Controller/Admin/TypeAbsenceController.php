<?php

namespace App\Controller\Admin;

use App\Entity\TypeAbsence;
use App\Form\TypeAbsenceType;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeAbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/type/absence')]
#[IsGranted("ROLE_SUPER_ADMIN")]
class TypeAbsenceController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_absence_index', methods: ['GET'])]
    public function index(TypeAbsenceRepository $typeAbsenceRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_absence/index.html.twig', [
            'type_absences' => $typeAbsenceRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_type_absence_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager,MessagesRepository $messagesRepository, TypeAbsenceRepository $typeAbsenceRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeAbsence = new TypeAbsence();
        $form = $this->createForm(TypeAbsenceType::class, $typeAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeAbsence);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_absence/new.html.twig', [
            'type_absence' => $typeAbsence,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_absence_show', methods: ['GET'])]
    public function show(TypeAbsence $typeAbsence, TypeAbsenceRepository $typeAbsenceRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_absence/show.html.twig', [
            'type_absence' => $typeAbsence,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_absence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, TypeAbsence $typeAbsence, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(TypeAbsenceType::class, $typeAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_absence/edit.html.twig', [
            'messages' => $messages,
            'notifications' => $notifications,
            'type_absence' => $typeAbsence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_absence_delete', methods: ['GET','POST'])]
    public function delete(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, TypeAbsence $typeAbsence, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$typeAbsence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeAbsence);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_type_absence_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_agent/delete.html.twig',[
            'type_absence'=>$typeAbsence,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
