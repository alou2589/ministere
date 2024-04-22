<?php

namespace App\Controller\Admin;

use App\Entity\CongeAbsence;
use App\Form\CongeAbsenceType;
use App\Repository\CongeAbsenceRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Service\AesEncryptDecrypt;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/conge/absence')]
class CongeAbsenceController extends AbstractController
{
    #[Route('/', name: 'app_admin_conge_absence_index', methods: ['GET'])]
    public function index(CongeAbsenceRepository $congeAbsenceRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/conge_absence/index.html.twig', [
            'conge_absences' => $congeAbsenceRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_conge_absence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,AesEncryptDecrypt $aesEncryptDecrypt, SluggerInterface $slugger, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $congeAbsence = new CongeAbsence();
        $form = $this->createForm(CongeAbsenceType::class, $congeAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $congeAbsence->setOperateur($this->getUser());
            $interval=$congeAbsence->getDateDebut()->diff($congeAbsence->getDateFin());
            $nbJours=intval($interval->format("%a"));
            $congeAbsence->setNombreJour($nbJours);
            $entityManager->persist($congeAbsence);
            $entityManager->flush();

            /** @var UploadedFile $congeAbsenceFile */

            $congeAbsenceFile = $form->get('fichier')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($congeAbsenceFile) {
                $originalFilename = pathinfo($congeAbsenceFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$congeAbsenceFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $congeAbsenceFile->move(
                        $this->getParameter('fichiersAgent_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $congeAbsence->setFichier($newFilename);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_admin_conge_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/conge_absence/new.html.twig', [
            'conge_absence' => $congeAbsence,
            'form' => $form,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }

    #[Route('/{id}', name: 'app_admin_conge_absence_show', methods: ['GET'])]
    public function show(CongeAbsence $congeAbsence, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/conge_absence/show.html.twig', [
            'conge_absence' => $congeAbsence,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_conge_absence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CongeAbsence $congeAbsence, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository, EntityManagerInterface $entityManager): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(CongeAbsenceType::class, $congeAbsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_conge_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/conge_absence/edit.html.twig', [
            'conge_absence' => $congeAbsence,
            'form' => $form,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_conge_absence_delete', methods: ['POST'])]
    public function delete(Request $request, CongeAbsence $congeAbsence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$congeAbsence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($congeAbsence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_conge_absence_index', [], Response::HTTP_SEE_OTHER);
    }
}
