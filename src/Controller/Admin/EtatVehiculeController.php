<?php

namespace App\Controller\Admin;

use App\Entity\EtatVehicule;
use App\Form\EtatVehiculeType;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\EtatVehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/etat_vehicule')]
#[IsGranted("ROLE_PARC_AUTO_ADMIN")]
class EtatVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_etat_vehicule_index', methods: ['GET'])]
    public function index(EtatVehiculeRepository $etatVehiculeRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/etat_vehicule/index.html.twig', [
            'etat_vehicules' => $etatVehiculeRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_etat_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager,MessagesRepository $messagesRepository, EtatVehiculeRepository $etatVehiculeRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $etatVehicule = new EtatVehicule();
        $form = $this->createForm(EtatVehiculeType::class, $etatVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etatVehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_etat_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etat_vehicule/new.html.twig', [
            'etat_vehicule' => $etatVehicule,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_etat_vehicule_show', methods: ['GET'])]
    public function show(EtatVehicule $etatVehicule, EtatVehiculeRepository $etatVehiculeRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/etat_vehicule/show.html.twig', [
            'etat_vehicule' => $etatVehicule,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_etat_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, EtatVehicule $etatVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(EtatVehiculeType::class, $etatVehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_etat_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etat_vehicule/edit.html.twig', [
            'messages' => $messages,
            'notifications' => $notifications,
            'etat_vehicule' => $etatVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_etat_vehicule_delete', methods: ['GET','POST'])]
    public function delete(Request $request, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, EtatVehicule $etatVehicule, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$etatVehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etatVehicule);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_etat_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/etat_vehicule/delete.html.twig',[
            'etat_vehicule'=>$etatVehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
