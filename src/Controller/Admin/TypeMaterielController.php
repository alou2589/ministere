<?php

namespace App\Controller\Admin;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use DeepCopy\TypeMatcher\TypeMatcher;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeMaterielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/type_materiel')]
#[IsGranted("ROLE_INFO_ADMIN")]
class TypeMaterielController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_materiel_index', methods: ['GET'])]
    public function index(TypeMaterielRepository $typeMaterielRepository,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_materiel/index.html.twig', [
            'type_materiels' => $typeMaterielRepository->findAll(),
            'notifications'=>$notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/new', name: 'app_admin_type_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MessagesRepository $messagesRepository, TypeMaterielRepository $typeMaterielRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeMateriel = new TypeMateriel();
        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMaterielRepository->save($typeMateriel, true);

            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_materiel/new.html.twig', [
            'type_materiel' => $typeMateriel,
            'notifications' => $notifications,
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_materiel_show', methods: ['GET'])]
    public function show(TypeMateriel $typeMateriel,MessagesRepository $messagesRepository, NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_materiel/show.html.twig', [
            'type_materiel' => $typeMateriel,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,MessagesRepository $messagesRepository, TypeMateriel $typeMateriel, TypeMaterielRepository $typeMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMaterielRepository->save($typeMateriel, true);

            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_materiel/edit.html.twig', [
            'type_materiel' => $typeMateriel,
            'form' => $form,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_materiel_delete', methods: ['GET','POST'])]
    public function delete(Request $request,MessagesRepository $messagesRepository, TypeMateriel $typeMateriel, TypeMaterielRepository $typeMaterielRepository,NotificationRepository $notificationRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        if ($this->isCsrfTokenValid('delete'.$typeMateriel->getId(), $request->request->get('_token'))) {
            $typeMaterielRepository->remove($typeMateriel, true);
            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_materiel/delete.html.twig',[
            'type_materiel'=>$typeMateriel,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_type_materiel_liste', methods: ['GET','POST'])]
    public function listepc(TypeMateriel $typeMateriel,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository)
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        return $this->render('admin/type_materiel/liste.html.twig',[
            'type_materiel'=>$typeMateriel,
            'messages' => $messages,
            'notifications' => $notifications,
        ]);
    }
}
