<?php

namespace App\Controller\Admin;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\MessagesRepository;
use App\Repository\FournisseurRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/fournisseur')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class FournisseurController extends AbstractController
{
    #[Route('/', name: 'app_admin_fournisseur_index', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseurRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, FournisseurRepository $fournisseurRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->save($fournisseur, true);

            return $this->redirectToRoute('app_admin_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fournisseur/new.html.twig', [
            'fournisseur' => $fournisseur,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_fournisseur_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->save($fournisseur, true);

            return $this->redirectToRoute('app_admin_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_fournisseur_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $fournisseurRepository->remove($fournisseur, true);
            return $this->redirectToRoute('app_admin_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/fournisseur/delete.html.twig',[
            'fournisseur'=>$fournisseur,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_fournisseur_liste', methods: ['GET'])]
    public function liste(Fournisseur $fournisseur,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/fournisseur/liste.html.twig',[
            'fournisseur'=>$fournisseur,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
