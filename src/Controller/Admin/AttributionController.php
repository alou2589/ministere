<?php

namespace App\Controller\Admin;

use App\Entity\Attribution;
use App\Form\AttributionType;
use App\Repository\AttributionRepository;
use App\Service\QrCodeService;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin/attribution')]
#[IsGranted("ROLE_INFO_ADMIN")]
class AttributionController extends AbstractController
{
    #[Route('/', name: 'app_admin_attribution_index', methods: ['GET'])]
    public function index(AttributionRepository $attributionRepository): Response
    {
        return $this->render('admin/attribution/index.html.twig', [
            'attributions' => $attributionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_attribution_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttributionRepository $attributionRepository, QrCodeService $qrCodeService): Response
    {
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
        ]);
    }

    #[Route('/{id}', name: 'app_admin_attribution_show', methods: ['GET'])]
    public function show(Attribution $attribution): Response
    {
        return $this->render('admin/attribution/show.html.twig', [
            'attribution' => $attribution,
        ]);
    }

    #[Route('/{id}/showcode', name: 'app_admin_attribution_showcode', methods: ['GET'])]
    public function showcode(Attribution $attribution)
    {
        return $this->render('admin/attribution/showcode.html.twig',[
            'attribution'=>$attribution,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_attribution_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Attribution $attribution, AttributionRepository $attributionRepository): Response
    {
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attributionRepository->save($attribution, true);

            return $this->redirectToRoute('app_admin_attribution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/attribution/edit.html.twig', [
            'attribution' => $attribution,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: 'app_admin_attribution_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Attribution $attribution, AttributionRepository $attributionRepository, CacheManager $cacheManager): Response
    {
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
        ]);
    }
}
