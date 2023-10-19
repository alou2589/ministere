<?php

namespace App\Controller\Admin;

use App\Entity\TypeAgent;
use App\Form\TypeAgentType;
use App\Repository\MessagesRepository;
use App\Repository\TypeAgentRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/type_agent')]
//#[IsGranted("ROLE_RH_ADMIN")]
class TypeAgentController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_agent_index', methods: ['GET'])]
    public function index(TypeAgentRepository $typeAgentRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_agent/index.html.twig', [
            'type_agents' => $typeAgentRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_type_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, TypeAgentRepository $typeAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeAgent = new TypeAgent();
        $form = $this->createForm(TypeAgentType::class, $typeAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeAgentRepository->save($typeAgent, true);

            return $this->redirectToRoute('app_admin_type_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_agent/new.html.twig', [
            'type_agent' => $typeAgent,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_agent_show', methods: ['GET'])]
    public function show(TypeAgent $typeAgent,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_agent/show.html.twig', [
            'type_agent' => $typeAgent,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, TypeAgent $typeAgent, TypeAgentRepository $typeAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(TypeAgentType::class, $typeAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeAgentRepository->save($typeAgent, true);

            return $this->redirectToRoute('app_admin_type_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_agent/edit.html.twig', [
            'type_agent' => $typeAgent,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_agent_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, TypeAgent $typeAgent, TypeAgentRepository $typeAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$typeAgent->getId(), $request->request->get('_token'))) {
            $typeAgentRepository->remove($typeAgent, true);
            return $this->redirectToRoute('app_admin_type_agent_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_agent/delete.html.twig',[
            'type_agent'=>$typeAgent,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
