<?php

namespace App\Controller\Admin;

use App\Entity\StatutAgent;
use App\Form\StatutAgentType;
use App\Repository\MessagesRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/statut_agent')]
//#[IsGranted("ROLE_RH_ADMIN")]
class StatutAgentController extends AbstractController
{
    #[Route('/', name: 'app_admin_statut_agent_index', methods: ['GET'])]
    public function index(StatutAgentRepository $statutAgentRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/statut_agent/index.html.twig', [
            'statut_agents' => $statutAgentRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_statut_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, StatutAgentRepository $statutAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $statutAgent = new StatutAgent();
        $form = $this->createForm(StatutAgentType::class, $statutAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutAgentRepository->save($statutAgent, true);

            return $this->redirectToRoute('app_admin_statut_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_agent/new.html.twig', [
            'statut_agent' => $statutAgent,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_statut_agent_show', methods: ['GET'])]
    public function show(StatutAgent $statutAgent,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/statut_agent/show.html.twig', [
            'statut_agent' => $statutAgent,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_statut_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, StatutAgent $statutAgent, StatutAgentRepository $statutAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $form = $this->createForm(StatutAgentType::class, $statutAgent);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutAgentRepository->save($statutAgent, true);

            return $this->redirectToRoute('app_admin_statut_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_agent/edit.html.twig', [
            'statut_agent' => $statutAgent,
            'messages' => $messages,
            'form' => $form,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_statut_agent_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, StatutAgent $statutAgent, StatutAgentRepository $statutAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$statutAgent->getId(), $request->request->get('_token'))) {
            $statutAgentRepository->remove($statutAgent, true);
            return $this->redirectToRoute('app_admin_statut_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_agent/delete.html.twig', [
            'statut_agent' => $statutAgent,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }
}
