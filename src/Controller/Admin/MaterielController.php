<?php

namespace App\Controller\Admin;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Entity\Attribution;
use App\Service\QrCodeService;
use App\Form\MatosAttributionFormType;
use App\Repository\MaterielRepository;
use App\Repository\MessagesRepository;
use App\Repository\AttributionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/materiel')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'app_admin_materiel_index', methods: ['GET'])]
    public function index(MaterielRepository $materielRepository,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        
        return $this->render('admin/materiel/index.html.twig', [
            'materiels' => $materielRepository->findAll(),
            'notifications'=>$notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, MaterielRepository $materielRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->save($materiel, true);

            return $this->redirectToRoute('app_admin_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/materiel/new.html.twig', [
            'materiel' => $materiel,
            'notifications' => $notifications,
            'messages' => $messages,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/materiel/show.html.twig', [
            'materiel' => $materiel,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, Materiel $materiel, MaterielRepository $materielRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->save($materiel, true);

            return $this->redirectToRoute('app_admin_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/materiel/edit.html.twig', [
            'materiel' => $materiel,
            'messages' => $messages,
            'notifications' => $notifications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_materiel_delete', methods: ['POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, Materiel $materiel, MaterielRepository $materielRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$materiel->getId(), $request->request->get('_token'))) {
            $materielRepository->remove($materiel, true);
            return $this->redirectToRoute('app_admin_materiel_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/materiel/delete.html.twig',[
            'materiel'=>$materiel,
            'notifications'=>$notifications,
            'messages' => $messages,
        ]);

    }
    #[Route('/{id}/new_attribution', name: 'app_admin_materiel_attribution', methods:['GET','POST'])]
    public function add_attribution(Request $request,MessagesRepository $messagesRepository,Materiel $materiel, AttributionRepository $attributionRepository, QrCodeService $qrCodeService, NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications=$notificationRepository->findBy(['status'=>false]);
        $attribution = new Attribution();
        $form = $this->createForm(MatosAttributionFormType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attribution->setMatos($materiel);
            $qr_code = $qrCodeService->qrcode_matos($attribution->getMatos()->getId(), $attribution->getId());

            $attribution->setQrCodeAttribution((string)$qr_code);
            $attributionRepository->save($attribution, true);
            return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/materiel/attribution.html.twig',[
            'materiel'=>$materiel,
            'notifications'=>$notifications,
            'messages' => $messages,
            'form'=>$form
        ]);
    }
}
