<?php

namespace App\Controller\Admin;

use App\Entity\SousStructure;
use App\Form\SousStructureType;
use App\Repository\AffectationRepository;
use App\Repository\AgentRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\SousStructureRepository;
use App\Repository\StatutAgentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/sous_structure')]
class SousStructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_sous_structure_index', methods: ['GET'])]
    public function index(SousStructureRepository $sousStructureRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/sous_structure/index.html.twig', [
            'sous_structures' => $sousStructureRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_sous_structure_new', methods: ['GET', 'POST'])]
    //#[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request,MessagesRepository $messagesRepository, SousStructureRepository $sousStructureRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $sousStructure = new SousStructure();
        $form = $this->createForm(SousStructureType::class, $sousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousStructureRepository->save($sousStructure, true);

            return $this->redirectToRoute('app_admin_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sous_structure/new.html.twig', [
            'sous_structure' => $sousStructure,
            'notifications' => $notifications,
            'messages' => $messages,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sous_structure_show', methods: ['GET'])]
    public function show(AffectationRepository $affectationRepository,SousStructure $sousStructure,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $hommes=$affectationRepository->affectationBySousStructureGenre("homme",$sousStructure->getNomSousStructure());
        $femmes=$affectationRepository->affectationBySousStructureGenre("femme",$sousStructure->getNomSousStructure());
        return $this->render('admin/sous_structure/show.html.twig', [
            'sous_structure' => $sousStructure,
            'notifications' => $notifications,
            'messages' => $messages,
            'hommes' => count($hommes),
            'femmes' =>count($femmes),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sous_structure_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request,MessagesRepository $messagesRepository, SousStructure $sousStructure, SousStructureRepository $sousStructureRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(SousStructureType::class, $sousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousStructureRepository->save($sousStructure, true);

            return $this->redirectToRoute('app_admin_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sous_structure/edit.html.twig', [
            'sous_structure' => $sousStructure,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_sous_structure_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request,MessagesRepository $messagesRepository, SousStructure $sousStructure, SousStructureRepository $sousStructureRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$sousStructure->getId(), $request->request->get('_token'))) {
            $sousStructureRepository->remove($sousStructure, true);
        }
        return $this->render('admin/sous_structure/delete.html.twig',[
            'sous_structure'=>$sousStructure,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/show_agents', name: 'app_admin_sous_structure_show_agents', methods: ['GET'])]
    public function show_agents(SousStructure $sous_structure,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/sous_structure/show_agents.html.twig',[
            'sous_structure'=>$sous_structure,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
