<?php

namespace App\Controller\Admin;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/poste')]
//#[IsGranted("ROLE_RH_ADMIN")]
class PosteController extends AbstractController
{
    #[Route('/', name: 'app_admin_poste_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, PosteRepository $posteRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->save($poste, true);

            return $this->redirectToRoute('app_admin_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/poste/new.html.twig', [
            'poste' => $poste,
            'notifications' => $notifications,
            'messages' => $messages,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_poste_show', methods: ['GET'])]
    public function show(Poste $poste,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/poste/show.html.twig', [
            'poste' => $poste,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_poste_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, Poste $poste, PosteRepository $posteRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posteRepository->save($poste, true);

            return $this->redirectToRoute('app_admin_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/poste/edit.html.twig', [
            'poste' => $poste,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_poste_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, Poste $poste, PosteRepository $posteRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$poste->getId(), $request->request->get('_token'))) {
            $posteRepository->remove($poste, true);
        }

        return $this->render('admin/poste/delete.html.twig',[
            'poste'=>$poste,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/listeAgents', name: 'app_admin_poste_agents', methods: ['GET','POST'])]
    public function agentsByPoste(Poste $poste,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/poste/agentsByPoste.html.twig',[
            'poste'=>$poste,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
