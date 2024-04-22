<?php

namespace App\Controller\Admin;

use App\Entity\Affectation;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/affectation')]
#[IsGranted("ROLE_RH_ADMIN")]
class AffectationController extends AbstractController
{
    #[Route('/', name: 'app_admin_affectation_index', methods: ['GET'])]
    public function index(Request $request,AffectationRepository $affectationRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/affectation/index.html.twig', [
            'affectations' => $affectationRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_affectation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $affectation = new Affectation();
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affectation);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/affectation/new.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_affectation_show', methods: ['GET'])]
    public function show(Affectation $affectation,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/affectation/show.html.twig', [
            'affectation' => $affectation,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_affectation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affectation $affectation, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/affectation/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_affectation_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request, Affectation $affectation, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$affectation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($affectation);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/affectation/delete.html.twig',[
            'affectation'=>$affectation,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
