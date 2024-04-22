<?php

namespace App\Controller\Admin;

use App\Entity\CartePro;
use App\Form\CarteProType;
use App\Service\QrCodeService;
use App\Service\AesEncryptDecrypt;
use App\Repository\CarteProRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/carte_pro')]
#[IsGranted("ROLE_RH_ADMIN")]
class CarteProController extends AbstractController
{
    #[Route('/', name: 'app_admin_carte_pro_index', methods: ['GET'])]
    public function index(CarteProRepository $carteProRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/carte_pro/index.html.twig', [
            'carte_pros' => $carteProRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_carte_pro_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, CarteProRepository $carteProRepository, QrCodeService $qrCodeService,AesEncryptDecrypt $aesEncryptDecrypt, SluggerInterface $slugger,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $cartePro = new CartePro();
        $qr_code = null;
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartePro->setQrcodeAgent((string)$qr_code);
            $carteProRepository->save($cartePro, true);
            $qr_code = $qrCodeService->qrcode($cartePro->getAffectation()->getId(), $cartePro->getId());

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

            $cartePro->setQrcodeAgent($aesEncryptDecrypt->encrypt((string)$qr_code));
            $cartePro->setStatusImpression("0");
            $carteProRepository->save($cartePro, true);

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/new.html.twig', [
            'carte_pro' => $cartePro,
            'form' => $form,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admin_carte_pro_show', methods: ['GET'])]
    public function show(CartePro $cartePro,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository,AesEncryptDecrypt $aesEncryptDecrypt): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $qrCodeAgent=$aesEncryptDecrypt->decrypt($cartePro->getQrcodeAgent());
        return $this->render('admin/carte_pro/show.html.twig', [
            'carte_pro' => $cartePro,
            'notifications' => $notifications,
            'qrCodeAgent'=>$qrCodeAgent,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/showcode', name: 'app_admin_carte_pro_show_code', methods: ['GET','POST'])]
    public function showcode(CartePro $cartePro,MessagesRepository $messagesRepository,AesEncryptDecrypt $aesEncryptDecrypt, NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $qrCodeAgent=$aesEncryptDecrypt->decrypt($cartePro->getQrcodeAgent());
        return $this->render('admin/carte_pro/generer_cartePro.html.twig',[
            'carte_pro'=>$cartePro,
            'qrCodeAgent'=>$qrCodeAgent,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carte_pro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, CartePro $cartePro, CarteProRepository $carteProRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(CarteProType::class, $cartePro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carteProRepository->save($cartePro, true);

            return $this->redirectToRoute('app_admin_carte_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/carte_pro/edit.html.twig', [
            'carte_pro' => $cartePro,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_carte_pro_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, CartePro $cartePro, CarteProRepository $carteProRepository, CacheManager $cacheManager,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$cartePro->getId(), $request->request->get('_token'))) {
            $photo_agent = $cartePro->getPhotoAgent();
            $cheminQrCode = '/Users/alassanetambedou/ministere/public/assets/qr-code/'. $cartePro->getId().'.png';
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
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
