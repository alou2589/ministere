<?php

namespace App\Controller\Admin;

use App\Entity\AffectationVehicule;
use App\Form\AffectationVehiculeType;
use App\Repository\AffectationVehiculeRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/affectation_vehicule')]
#[IsGranted("ROLE_PARC_AUTO_ADMIN")]
class AffectationVehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_affectation_vehicule_index', methods: ['GET'])]
    public function index(Request $request,AffectationVehiculeRepository $affectationVehiculeRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        //dd($affectationVehiculeRepository->findAll());
        return $this->render('admin/affectation_vehicule/index.html.twig', [
            'affectation_vehicules' => $affectationVehiculeRepository->findWithAgentStructure(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_affectation_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $affectation_vehicule = new AffectationVehicule();
        $form = $this->createForm(AffectationVehiculeType::class, $affectation_vehicule) ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affectation_vehicule) ;
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/affectation_vehicule/new.html.twig', [
            'affectation_vehicule'=> $affectation_vehicule,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_affectation_vehicule_show', methods: ['GET'])]
    public function show(AffectationVehicule $affectation_vehicule,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/affectation_vehicule/show.html.twig', [
            'affectation_vehicule'=> $affectation_vehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_affectation_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AffectationVehicule $affectation_vehicule, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(AffectationVehiculeType::class, $affectation_vehicule) ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/affectation_vehicule/edit.html.twig', [
            'affectation_vehicule'=> $affectation_vehicule,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_affectation_vehicule_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request, AffectationVehicule $affectation_vehicule, EntityManagerInterface $entityManager,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$affectation_vehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($affectation_vehicule) ;
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_affectation_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/affectation_vehicule/edit.html.twig',[
            'affectation_vehicule'=>$affectation_vehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }
}
