<?php

namespace App\Controller\Admin;

use App\Entity\CategorieMateriel;
use App\Form\CategorieMaterielType;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategorieMaterielRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categorie_materiel')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class CategorieMaterielController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_materiel_index', methods: ['GET'])]
    public function index(MessagesRepository $messagesRepository,CategorieMaterielRepository $categorieMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/categorie_materiel/index.html.twig', [
            'categorie_materiels' => $categorieMaterielRepository->findAll(),
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, CategorieMaterielRepository $categorieMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $categorieMateriel = new CategorieMateriel();
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->save($categorieMateriel, true);

            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie_materiel/new.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_materiel_show', methods: ['GET'])]
    public function show(CategorieMateriel $categorieMateriel,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/categorie_materiel/show.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->save($categorieMateriel, true);

            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie_materiel/edit.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_categorie_materiel_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$categorieMateriel->getId(), $request->request->get('_token'))) {
            $categorieMaterielRepository->remove($categorieMateriel, true);
            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/categorie_materiel/delete.html.twig',[
            'categorie_materiel'=>$categorieMateriel,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_categorie_materiel_liste', methods: ['GET', 'POST'])]
    public function listepc(MessagesRepository $messagesRepository,CategorieMateriel $categorieMateriel,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/categorie_materiel/liste.html.twig',[
            'categorie_materiel'=>$categorieMateriel,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
