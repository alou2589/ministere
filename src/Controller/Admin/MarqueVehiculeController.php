<?php

namespace App\Controller\Admin;

use App\Entity\MarqueVehicule;
use App\Form\MarqueVehiculeType;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\MarqueVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/marque_vehicule')]
#[IsGranted("ROLE_PARC_AUTO_ADMIN")]
class MarqueVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_marque_vehicule_index', methods: ['GET'])]
    public function index(MarqueVehiculeRepository $marqueVehiculeRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/marque_vehicule/index.html.twig', [
            'marque_vehicules' => $marqueVehiculeRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_marque_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager,MessagesRepository $messagesRepository, MarqueVehiculeRepository $marqueVehiculeRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $marqueVehicule = new MarqueVehicule();
        $form = $this->createForm(MarqueVehiculeType::class, $marqueVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marqueVehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_marque_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_vehicule/new.html.twig', [
            'marque_vehicule' => $marqueVehicule,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_vehicule_show', methods: ['GET'])]
    public function show(MarqueVehicule $marqueVehicule, MarqueVehiculeRepository $marqueVehiculeRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/marque_vehicule/show.html.twig', [
            'marque_vehicule' => $marqueVehicule,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_marque_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, MarqueVehicule $marqueVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(MarqueVehiculeType::class, $marqueVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_marque_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_vehicule/edit.html.twig', [
            'messages' => $messages,
            'notifications' => $notifications,
            'marque_vehicule' => $marqueVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_vehicule_delete', methods: ['GET','POST'])]
    public function delete(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, MarqueVehicule $marqueVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$marqueVehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($marqueVehicule);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_marque_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/marque_vehicule/delete.html.twig',[
            'marque_vehicule'=>$marqueVehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
