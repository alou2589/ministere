<?php

namespace App\Controller\Admin;

use App\Entity\Attribution;
use App\Entity\Materiel;
use App\Entity\Vehicule;
use App\Form\MatosAttributionFormType;
use App\Form\VehiculeType;
use App\Repository\AttributionRepository;
use App\Repository\MaterielRepository;
use App\Repository\VehiculeRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Service\QrCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/vehicule')]
#[IsGranted("ROLE_PARC_AUTO_ADMIN")]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'app_admin_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
        $notifications = $notificationRepository->findBy(['status' => false]);

        return $this->render('admin/vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAllWithTypeAndMarque(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request,EntityManagerInterface $entityManager, MessagesRepository $messagesRepository, vehiculeRepository $vehiculeRepository, NotificationRepository $notificationRepository): Response
    {
        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
        $notifications = $notificationRepository->findBy(['status' => false]);
        $vehicule = new vehicule();
        $form = $this->createForm(vehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'notifications' => $notifications,
            'messages' => $messages,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_vehicule_show', methods: ['GET'])]
    public function show(vehicule $vehicule, MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
        $notifications = $notificationRepository->findBy(['status' => false]);
        return $this->render('admin/vehicule/show.html.twig', [
            'vehicule' => $vehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_admin_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, MessagesRepository $messagesRepository, Vehicule $vehicule, VehiculeRepository $vehiculeRepository, NotificationRepository $notificationRepository): Response
    {
        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
        $notifications = $notificationRepository->findBy(['status' => false]);
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, MessagesRepository $messagesRepository, Materiel $vehicule, MaterielRepository $vehiculeRepository, NotificationRepository $notificationRepository): Response
    {
        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
        $notifications = $notificationRepository->findBy(['status' => false]);
        if ($this->isCsrfTokenValid('delete' . $vehicule->getId(), $request->request->get('_token'))) {
            $vehiculeRepository->remove($vehicule, true);
            return $this->redirectToRoute('app_admin_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }


   // #[Route('/{id}/new_attribution', name: 'app_admin_vehicule_attribution', methods: ['GET', 'POST'])]
//    public function add_attribution(Request $request, MessagesRepository $messagesRepository, Materiel $vehicule, AttributionRepository $attributionRepository, QrCodeService $qrCodeService, NotificationRepository $notificationRepository)
//    {
//        $messages = $messagesRepository->findBy(['status' => 'Non Lu', 'destinataire' => $this->getUser()]);
//        $notifications = $notificationRepository->findBy(['status' => false]);
//        $attribution = new Attribution();
//        $form = $this->createForm(MatosAttributionFormType::class, $attribution);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $attribution->setMatos($vehicule);
//            $qr_code = $qrCodeService->qrcode_matos($attribution->getMatos()->getId(), $attribution->getId());
//
//            $attribution->setQrCodeAttribution((string)$qr_code);
//            $attributionRepository->save($attribution, true);
//            return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('admin/vehicule/attribution.html.twig', [
//            'vehicule' => $vehicule,
//            'notifications' => $notifications,
//            'messages' => $messages,
//            'form' => $form
//        ]);
//    }

}
