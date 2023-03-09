<?php

namespace App\Controller\Admin;

use App\Entity\Technicien;
use App\Form\TechnicienType;
use App\Repository\TechnicienRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/technicien')]
#[IsGranted("ROLE_INFO_ADMIN")]
class TechnicienController extends AbstractController
{
    #[Route('/', name: 'app_admin_technicien_index', methods: ['GET'])]
    public function index(TechnicienRepository $technicienRepository): Response
    {
        return $this->render('admin/technicien/index.html.twig', [
            'techniciens' => $technicienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_technicien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TechnicienRepository $technicienRepository): Response
    {
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technicienRepository->save($technicien, true);

            return $this->redirectToRoute('app_admin_technicien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/technicien/new.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_technicien_show', methods: ['GET'])]
    public function show(Technicien $technicien): Response
    {
        return $this->render('admin/technicien/show.html.twig', [
            'technicien' => $technicien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_technicien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Technicien $technicien, TechnicienRepository $technicienRepository): Response
    {
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technicienRepository->save($technicien, true);

            return $this->redirectToRoute('app_admin_technicien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/technicien/edit.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_technicien_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Technicien $technicien, TechnicienRepository $technicienRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technicien->getId(), $request->request->get('_token'))) {
            $technicienRepository->remove($technicien, true);
            return $this->redirectToRoute('app_admin_technicien_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/technicien/delete.html.twig',[
            'technicien'=>$technicien,
        ]);

    }
}
