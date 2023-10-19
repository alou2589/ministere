<?php

namespace App\Controller\Admin;

use App\Entity\Attribution;
use App\Form\AttributionType;
use App\Service\QrCodeService;
use App\Repository\MessagesRepository;
use App\Repository\AttributionRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/attribution')]
#[IsGranted("ROLE_INFO_ADMIN")]
class AttributionController extends AbstractController
{
    #[Route('/', name: 'app_admin_attribution_index', methods: ['GET'])]
    public function index(AttributionRepository $attributionRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/attribution/index.html.twig', [
            'attributions' => $attributionRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_attribution_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, AttributionRepository $attributionRepository, QrCodeService $qrCodeService,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $attribution = new Attribution();
        $qr_code = null;
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attribution->setQrCodeAttribution((string)$qr_code);
            $attributionRepository->save($attribution, true);
            $qr_code = $qrCodeService->qrcode_matos($attribution->getMatos()->getId(), $attribution->getId());

            $attribution->setQrCodeAttribution((string)$qr_code);
            $attributionRepository->save($attribution, true);
            return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/attribution/new.html.twig', [
            'attribution' => $attribution,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_attribution_show', methods: ['GET'])]
    public function show(Attribution $attribution,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/attribution/show.html.twig', [
            'attribution' => $attribution,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/showcode', name: 'app_admin_attribution_showcode', methods: ['GET'])]
    public function showcode(Attribution $attribution,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/attribution/showcode.html.twig',[
            'attribution'=>$attribution,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_attribution_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, Attribution $attribution, AttributionRepository $attributionRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributionRepository->save($attribution, true);

            return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/attribution/edit.html.twig', [
            'attribution' => $attribution,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }
    #[Route('/{id}/delete', name: 'app_admin_attribution_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, Attribution $attribution, AttributionRepository $attributionRepository, CacheManager $cacheManager,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$attribution->getId(), $request->request->get('_token'))) {
            $cheminQrCode = '/Users/alassanetambedou/Desktop/ministere/public/assets/matos_qr-code/'. $attribution->getId().'.png';
            if (file_exists($cheminQrCode)) {
                unlink($cheminQrCode);
                $cacheManager->remove();
                $attributionRepository->remove($attribution, true);
                return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('admin/attribution/delete.html.twig',[
            'attribution'=>$attribution,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
