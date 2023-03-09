<?php

namespace App\Controller\Admin;

use App\Entity\MarqueMatos;
use App\Form\MarqueMatosType;
use App\Repository\MarqueMatosRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/marque_matos')]
#[IsGranted("ROLE_INFO_ADMIN")]
class MarqueMatosController extends AbstractController
{
    #[Route('/', name: 'app_admin_marque_matos_index', methods: ['GET'])]
    public function index(MarqueMatosRepository $marqueMatosRepository): Response
    {
        return $this->render('admin/marque_matos/index.html.twig', [
            'marque_matos' => $marqueMatosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_marque_matos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MarqueMatosRepository $marqueMatosRepository): Response
    {
        $marqueMato = new MarqueMatos();
        $form = $this->createForm(MarqueMatosType::class, $marqueMato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueMatosRepository->save($marqueMato, true);

            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_matos/new.html.twig', [
            'marque_mato' => $marqueMato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_marque_matos_show', methods: ['GET'])]
    public function show(MarqueMatos $marqueMato): Response
    {
        return $this->render('admin/marque_matos/show.html.twig', [
            'marque_mato' => $marqueMato,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_marque_matos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MarqueMatos $marqueMato, MarqueMatosRepository $marqueMatosRepository): Response
    {
        $form = $this->createForm(MarqueMatosType::class, $marqueMato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueMatosRepository->save($marqueMato, true);

            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/marque_matos/edit.html.twig', [
            'marque_mato' => $marqueMato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_marque_matos_delete', methods: ['GET','POST'])]
    public function delete(Request $request, MarqueMatos $marqueMato, MarqueMatosRepository $marqueMatosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marqueMato->getId(), $request->request->get('_token'))) {
            $marqueMatosRepository->remove($marqueMato, true);
            return $this->redirectToRoute('app_admin_marque_matos_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/marque_matos/delete.html.twig',[
            'marque_mato'=>$marqueMato
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_marque_matos_liste', methods: ['GET', 'POST'])]
    public function liste(MarqueMatos $marqueMatos)
    {
        return $this->render('admin/marque_matos/liste.html.twig',[
            'marque_mato'=>$marqueMatos,
        ]);
    }
}
