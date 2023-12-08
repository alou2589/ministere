<?php

namespace App\Controller\Admin;

use App\Entity\FichiersAgent;
use App\Form\FichiersAgentType;
use App\Service\AesEncryptDecrypt;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotificationRepository;
use App\Repository\FichiersAgentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/fichiers/agent')]
class FichiersAgentController extends AbstractController
{
    #[Route('/', name: 'app_admin_fichiers_agent_index', methods: ['GET'])]
    public function index(FichiersAgentRepository $fichiersAgentRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/fichiers_agent/index.html.twig', [
            'fichiers_agents' => $fichiersAgentRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_fichiers_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, FichiersAgentRepository $fichiersagentRepository, AesEncryptDecrypt $aesEncryptDecrypt, SluggerInterface $slugger,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $fichiersAgent = new FichiersAgent();
        $form = $this->createForm(FichiersAgentType::class, $fichiersAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichiersagentRepository->save($fichiersAgent, true);
            $agentFile = $form->get('nom_fichier')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($agentFile) {
                $originalFilename = pathinfo($agentFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$agentFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $agentFile->move(
                        $this->getParameter('fichiersAgent_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $fichiersAgent->setNomFichier($newFilename);
            }

            return $this->redirectToRoute('app_admin_fichiers_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fichiers_agent/new.html.twig', [
            'fichiers_agent' => $fichiersagentRepository,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_fichiers_agent_show', methods: ['GET'])]
    public function show(FichiersAgent $fichiersAgent): Response
    {
        return $this->render('admin/fichiers_agent/show.html.twig', [
            'fichiers_agent' => $fichiersAgent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_fichiers_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FichiersAgent $fichiersAgent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FichiersAgentType::class, $fichiersAgent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_fichiers_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/fichiers_agent/edit.html.twig', [
            'fichiers_agent' => $fichiersAgent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_fichiers_agent_delete', methods: ['POST'])]
    public function delete(Request $request, FichiersAgent $fichiersAgent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichiersAgent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fichiersAgent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_fichiers_agent_index', [], Response::HTTP_SEE_OTHER);
    }
}
