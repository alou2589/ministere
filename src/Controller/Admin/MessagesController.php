<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/messages')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class MessagesController extends AbstractController
{
    #[Route('/', name: 'app_admin_messages_index', methods: ['GET'])]
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('admin/messages/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_messages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessagesRepository $messagesRepository): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messagesRepository->save($message, true);

            return $this->redirectToRoute('app_admin_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/messages/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_messages_show', methods: ['GET'])]
    public function show(Messages $message): Response
    {
        return $this->render('admin/messages/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_messages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Messages $message, MessagesRepository $messagesRepository): Response
    {
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messagesRepository->save($message, true);

            return $this->redirectToRoute('app_admin_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/messages/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_messages_delete', methods: ['POST'])]
    public function delete(Request $request, Messages $message, MessagesRepository $messagesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messagesRepository->remove($message, true);
        }

        return $this->redirectToRoute('app_admin_messages_index', [], Response::HTTP_SEE_OTHER);
    }
}
