<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Entity\HistoriqueRH;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use App\Repository\CarteProRepository;
use App\Repository\StatutAgentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/agent')]
class AgentController extends AbstractController
{
    #[Route('/', name: 'app_admin_agent_index', methods: ['GET'])]
    public function index(AgentRepository $agentRepository): Response
    {
        return $this->render('admin/agent/index.html.twig', [
            'agents' => $agentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_agent_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request, AgentRepository $agentRepository): Response
    {
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
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_agent_show', methods: ['GET'])]
    public function show(Agent $agent, CarteProRepository $carteProRepository, StatutAgentRepository $statutAgentRepository): Response
    {
        $cartePro = $carteProRepository->findOneBy(['agent' => $agent->getId()]);
        $statutAgent = $statutAgentRepository->findOneBy(['agent' => $agent->getId()]);
        return $this->render('admin/agent/show.html.twig', [
            'agent' => $agent,
            'statut_agent' => $statutAgent,
            'carte_pro' => $cartePro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_agent_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request, Agent $agent, AgentRepository $agentRepository): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agentRepository->save($agent, true);

            return $this->redirectToRoute('app_admin_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/agent/edit.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_agent_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request, Agent $agent, AgentRepository $agentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $agentRepository->remove($agent, true);
            return $this->redirectToRoute('app_admin_agent_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/agent/delete.html.twig',[
            'agent'=>$agent,
        ]);
    }
}
