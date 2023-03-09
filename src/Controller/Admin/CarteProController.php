<?php

namespace App\Controller\Admin;

use App\Entity\CartePro;
use App\Form\CarteProType;
use App\Repository\CarteProRepository;
use App\Service\QrCodeService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Label\Font\OpenSans;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

use function PHPUnit\Framework\fileExists;

#[Route('/admin/carte_pro')]
#[IsGranted("ROLE_RH_ADMIN")]
class CarteProController extends AbstractController
{
    #[Route('/', name: 'app_admin_carte_pro_index', methods: ['GET'])]
    public function index(CarteProRepository $carteProRepository): Response
    {
        return $this->render('admin/carte_pro/index.html.twig', [
            'carte_pros' => $carteProRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_carte_pro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarteProRepository $carteProRepository, QrCodeService $qrCodeService, SluggerInterface $slugger): Response
    {
        $cartePro = new CartePro();
        $qr_code = null;
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartePro->setQrcodeAgent((string)$qr_code);
            $carteProRepository->save($cartePro, true);
            $qr_code = $qrCodeService->qrcode($cartePro->getAgent()->getId(), $cartePro->getId());

            $imageFile = $form->get('photo_agent')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('photoAgent_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cartePro->setPhotoAgent($newFilename);
            }

            $cartePro->setQrcodeAgent((string)$qr_code);
            $cartePro->setStatusImpression(false);
            $carteProRepository->save($cartePro, true);

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/new.html.twig', [
            'carte_pro' => $cartePro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carte_pro_show', methods: ['GET'])]
    public function show(CartePro $cartePro): Response
    {
        return $this->render('admin/carte_pro/show.html.twig', [
            'carte_pro' => $cartePro,
        ]);
    }

    #[Route('/{id}/showcode', name: 'app_admin_carte_pro_show_code', methods: ['GET'])]
    public function showcode(CartePro $cartePro)
    {
        return $this->render('admin/carte_pro/generer_cartePro.html.twig',[
            'carte_pro'=>$cartePro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carte_pro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CartePro $cartePro, CarteProRepository $carteProRepository): Response
    {
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carteProRepository->save($cartePro, true);

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/edit.html.twig', [
            'carte_pro' => $cartePro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_carte_pro_delete', methods: ['GET','POST'])]
    public function delete(Request $request, CartePro $cartePro, CarteProRepository $carteProRepository, CacheManager $cacheManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cartePro->getId(), $request->request->get('_token'))) {
            $photo_agent = $cartePro->getPhotoAgent();
            $cheminQrCode = '/Users/alassanetambedou/Desktop/ministere/public/assets/qr-code/'. $cartePro->getId().'.png';
            $cheminPhoto=$this->getParameter("photoAgent_directory").'/'.$photo_agent;
            if (file_exists($cheminPhoto)) {
                unlink($cheminPhoto);
                unlink($cheminQrCode);
                $cacheManager->remove();
                $carteProRepository->remove($cartePro, true);
                return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('admin/carte_pro/delete.html.twig',[
            'carte_pro'=>$cartePro,
        ]);
    }
}
