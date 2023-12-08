<?php

namespace App\Controller\Admin;

use App\Entity\TypeFichier;
use App\Form\TypeFichierType;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TypeFichierRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/type/fichier')]
class TypeFichierController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_fichier_index', methods: ['GET'])]
    public function index(TypeFichierRepository $typeFichierRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_fichier/index.html.twig', [
            'type_fichiers' => $typeFichierRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_type_fichier_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, TypeFichierRepository $typeFichierRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeFichier = new TypeFichier();
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFichierRepository->save($typeFichier, true);

            return $this->redirectToRoute('app_admin_type_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_fichier/new.html.twig', [
            'type_fichier' => $typeFichier,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_fichier_show', methods: ['GET'])]
    public function show(TypeFichier $typeFichier,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_fichier/show.html.twig', [
            'type_fichier' => $typeFichier,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_fichier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, TypeFichier $typeFichier, TypeFichierRepository $typeFichierRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(TypeFichierType::class, $typeFichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFichierRepository->save($typeFichier, true);

            return $this->redirectToRoute('app_admin_type_fichier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_fichier/edit.html.twig', [
            'type_fichier' => $typeFichier,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_fichier_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, TypeFichier $typeFichier , TypeFichierRepository $typeFichierRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$typeFichier->getId(), $request->request->get('_token'))) {
            $typeFichierRepository->remove($typeFichier, true);
            return $this->redirectToRoute('app_admin_type_fichier_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_fichier/delete.html.twig',[
            'type_fichier'=>$typeFichier,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
