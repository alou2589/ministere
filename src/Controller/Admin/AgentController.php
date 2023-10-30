<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Entity\HistoriqueRH;
use App\Repository\AgentRepository;
use App\Repository\AttributionRepository;
use App\Repository\CarteProRepository;
use App\Repository\MessagesRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/agent')]
class AgentController extends AbstractController
{
    #[Route('/', name: 'app_admin_agent_index', methods: ['GET'])]
    public function index(AgentRepository $agentRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/agent/index.html.twig', [
            'agents' => $agentRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_agent_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request,MessagesRepository $messagesRepository, AgentRepository $agentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $agent = new Agent();
        $typeAction="Ajout Agent";
        $dateAction=new \DateTime();
        $historique_rh=new HistoriqueRH();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentRepository->save($agent, true);
            $historique_rh->setDateAction($dateAction);
            $historique_rh->setTypeAction($typeAction);
            $this->addFlash('completer', 'Completer les informations SVP !!!');
            return $this->redirectToRoute('app_admin_agent_show', ['id'=>$agent->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/agent/new.html.twig', [
            'agent' => $agent,
            'messages' => $messages,
            'form' => $form,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_agent_show', methods: ['GET'])]
    public function show(Agent $agent,MessagesRepository $messagesRepository,AttributionRepository $attributionRepository, CarteProRepository $carteProRepository, StatutAgentRepository $statutAgentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $cartePro = $carteProRepository->findOneBy(['agent' => $agent->getId()]);
        $attributions=$attributionRepository->findBy(['agent'=> $agent->getId()]);
        $statutAgent = $statutAgentRepository->findOneBy(['agent' => $agent->getId()]);
        return $this->render('admin/agent/show.html.twig', [
            'agent' => $agent,
            'statut_agent' => $statutAgent,
            'attributions' => $attributions,
            'notifications' => $notifications,
            'carte_pro' => $cartePro,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_agent_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request,MessagesRepository $messagesRepository, Agent $agent, AgentRepository $agentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentRepository->save($agent, true);

            return $this->redirectToRoute('app_admin_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/agent/edit.html.twig', [
            'agent' => $agent,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_agent_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request,MessagesRepository $messagesRepository, Agent $agent, AgentRepository $agentRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $agentRepository->remove($agent, true);
            return $this->redirectToRoute('app_admin_agent_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/agent/delete.html.twig',[
            'agent'=>$agent,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
