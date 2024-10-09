<?php

namespace App\Controller\Admin;

use App\Entity\TypeVehicule;
use App\Form\TypeVehiculeType;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/type_vehicule')]
#[IsGranted("ROLE_PARC_AUTO_ADMIN")]
class TypeVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_vehicule_index', methods: ['GET'])]
    public function index(TypeVehiculeRepository $typeVehiculeRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_vehicule/index.html.twig', [
            'type_vehicules' => $typeVehiculeRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_type_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager,MessagesRepository $messagesRepository, TypeVehiculeRepository $typeVehiculeRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeVehicule = new TypeVehicule();
        $form = $this->createForm(TypeVehiculeType::class, $typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeVehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_vehicule/new.html.twig', [
            'type_vehicule' => $typeVehicule,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_vehicule_show', methods: ['GET'])]
    public function show(TypeVehicule $typeVehicule, TypeVehiculeRepository $typeVehiculeRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_vehicule/show.html.twig', [
            'type_vehicule' => $typeVehicule,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, TypeVehicule $typeVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(TypeVehiculeType::class, $typeVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_vehicule/edit.html.twig', [
            'messages' => $messages,
            'notifications' => $notifications,
            'type_vehicule' => $typeVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_vehicule_delete', methods: ['GET','POST'])]
    public function delete(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, TypeVehicule $typeVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$typeVehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeVehicule);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_type_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_vehicule/delete.html.twig',[
            'type_vehicule'=>$typeVehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
