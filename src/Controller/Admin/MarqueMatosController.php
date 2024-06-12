<?php

namespace App\Controller\Admin;

use App\Entity\MarqueMatos;
use App\Form\MarqueMatosType;
use App\Repository\MessagesRepository;
use App\Repository\MarqueMatosRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/marque_matos')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class MarqueMatosController extends AbstractController
{
    #[Route('/', name: 'app_admin_marque_matos_index', methods: ['GET'])]
    public function index(MarqueMatosRepository $marqueMatosRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/marque_matos/index.html.twig', [
            'marque_matos' => $marqueMatosRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_marque_matos_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, MarqueMatosRepository $marqueMatosRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $marqueMato = new MarqueMatos();
        $form = $this->createForm(MarqueMatosType::class, $marqueMato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueMatosRepository->save($marqueMato, true);

            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_matos/new.html.twig', [
            'marque_mato' => $marqueMato,
            'messages' => $messages,
            'form' => $form,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_matos_show', methods: ['GET'])]
    public function show(MarqueMatos $marqueMato,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/marque_matos/show.html.twig', [
            'marque_mato' => $marqueMato,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_marque_matos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, MarqueMatos $marqueMato, MarqueMatosRepository $marqueMatosRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(MarqueMatosType::class, $marqueMato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueMatosRepository->save($marqueMato, true);

            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_matos/edit.html.twig', [
            'marque_mato' => $marqueMato,
            'messages' => $messages,
            'form' => $form,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_marque_matos_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, MarqueMatos $marqueMato, MarqueMatosRepository $marqueMatosRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$marqueMato->getId(), $request->request->get('_token'))) {
            $marqueMatosRepository->remove($marqueMato, true);
            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/marque_matos/delete.html.twig',[
            'marque_mato'=>$marqueMato,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_marque_matos_liste', methods: ['GET', 'POST'])]
    public function liste(MarqueMatos $marqueMatos,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/marque_matos/liste.html.twig',[
            'marque_mato'=>$marqueMatos,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
