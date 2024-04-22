<?php

namespace App\Controller\Admin;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\AffectationRepository;
use App\Repository\MessagesRepository;
use App\Repository\StructureRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/structure')]
class StructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_structure_index', methods: ['GET'])]
    public function index(StructureRepository $structureRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/structure/index.html.twig', [
            'structures' => $structureRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_structure_new', methods: ['GET', 'POST'])]
    //#[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request, StructureRepository $structureRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->save($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/structure/new.html.twig', [
            'structure' => $structure,
            'notifications' => $notifications,
            'messages' => $messages,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_structure_show', methods: ['GET'])]
    public function show(Structure $structure,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository, AffectationRepository $affectationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $hommes=$affectationRepository->affectationByStructureGenre($structure->getNomStructure(),"homme");
        $femmes=$affectationRepository->affectationByStructureGenre($structure->getNomStructure(),"femme");
        $affectations=$affectationRepository->affectation_structure($structure);
        return $this->render('admin/structure/show.html.twig', [
            'structure' => $structure,
            'notifications' => $notifications,
            'hommes' => count($hommes),
            'femmes' => count($femmes),
            'affectations' => count($affectations),
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_structure_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request,MessagesRepository $messagesRepository, Structure $structure, StructureRepository $structureRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->save($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/structure/edit.html.twig', [
            'structure' => $structure,
            'messages' => $messages,
            'form' => $form,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_structure_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request,MessagesRepository $messagesRepository, Structure $structure, StructureRepository $structureRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->request->get('_token'))) {
            $structureRepository->remove($structure, true);
        }

        return $this->render('admin/structure/delete.html.twig',[
            'structure'=>$structure,
            'messages' => $messages,
        ]);
    }
    
    #[Route('/{id}/show_services', name: 'app_admin_structure_show_services', methods: ['GET'])]
    public function show_services(Structure $structure,MessagesRepository $messagesRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        return $this->render('admin/structure/show_services.html.twig', [
            'structure' => $structure,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/show_agents', name: 'app_admin_structure_show_agents', methods: ['GET'])]
    public function show_agents(Structure $structure,MessagesRepository $messagesRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        return $this->render('admin/structure/show_agents.html.twig',[
            'structure'=>$structure,
            'messages' => $messages,
        ]);
    }
}
