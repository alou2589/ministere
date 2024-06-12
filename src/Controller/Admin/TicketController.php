<?php

namespace App\Controller\Admin;

use App\Entity\Maintenance;
use App\Entity\Ticket;
use App\Entity\Messages;
use App\Form\TicketType;
use App\Entity\Notification;
use App\Repository\MaintenanceRepository;
use App\Repository\TicketRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/ticket')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class TicketController extends AbstractController
{
    #[Route('/', name: 'app_admin_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/ticket/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository,MaintenanceRepository $maintenanceRepository, TicketRepository $ticketRepository,NotificationRepository $notificationRepository): Response
    {
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setSolutionApportee("....");
            $ticket->setObservationTechnicien("....");
            $ticket->setStatusTicket("Valider");
            $ticket->setStatutMatos("En Panne");
            $ticket->setDateSortie(new \DateTime());
            $ticketRepository->save($ticket, true);
            $maintenance=new Maintenance();
            
            $maintenance->setMatos($ticket->getMatos());
            $maintenance->setDateMaintenance($ticket->getDateDeclaration());
            $maintenance->setStatusMatos($ticket->getStatutMatos());
            
            $maintenanceRepository->save($maintenance,true);
            
            $notif=new Notification();
            $notif->setTicket($ticket);
            $notif->setTitre("Titre N°".$ticket->getId());
            $notif->setContenu($ticket->getDescriptionProprietaire()."vient de déclarer que ".$ticket->getMatos()->getModeleMatos()." est tombé en panne ");
            $notif->setDateNotification($ticket->getDateDeclaration());
            $notif->setStatus(false);
            
            $notificationRepository->save($notif, true);
            $technicien=$ticket->getTechnicien()->getInfoTechnicien()->getStatutAgent()->getAgent();
            $message_affectation=new Messages();
            $message_affectation->setExpediteur($this->getUser());
            $message_affectation->setDestinataire($ticket->getTechnicien()->getInfoTechnicien());
            $message_affectation->setTitre($notif->getTitre());
            $message_affectation->setContenu($technicien->getPrenom()." ".$technicien->getNom()." veuillez prendre en charge le ticket N° ".$ticket->getId());
            $message_affectation->setDateEnvoi(new \DateTime());
            $message_affectation->setStatus('Non Lu');
            
            $messagesRepository->save($message_affectation, true);

            return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/ticket/show.html.twig', [
            'ticket' => $ticket,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, Ticket $ticket, TicketRepository $ticketRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(EditTicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->save($ticket, true);
            
            $maintenance=new Maintenance();
            
            $maintenance->setMatos($ticket->getMatos());
            $maintenance->setDateMaintenance($ticket->getDateDeclaration());
            $maintenance->setStatusMatos($ticket->getStatutMatos());

            return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('app_admin_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
