<?php

namespace App\Controller\Admin;

use App\Entity\Historiques;
use App\Form\HistoriquesType;
use App\Repository\HistoriquesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/historiques')]
//#[IsGranted("ROLE_INFO_ADMIN")]
class HistoriquesController extends AbstractController
{
    #[Route('/', name: 'app_admin_historiques_index', methods: ['GET'])]
    public function index(HistoriquesRepository $historiquesRepository): Response
    {
        return $this->render('admin/historiques/index.html.twig', [
            'historiques' => $historiquesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_historiques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HistoriquesRepository $historiquesRepository): Response
    {
        $historique = new Historiques();
        $form = $this->createForm(HistoriquesType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historiquesRepository->save($historique, true);

            return $this->redirectToRoute('app_admin_historiques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/historiques/new.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_historiques_show', methods: ['GET'])]
    public function show(Historiques $historique): Response
    {
        return $this->render('admin/historiques/show.html.twig', [
            'historique' => $historique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_historiques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Historiques $historique, HistoriquesRepository $historiquesRepository): Response
    {
        $form = $this->createForm(HistoriquesType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historiquesRepository->save($historique, true);

            return $this->redirectToRoute('app_admin_historiques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/historiques/edit.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_historiques_delete', methods: ['POST'])]
    public function delete(Request $request, Historiques $historique, HistoriquesRepository $historiquesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historique->getId(), $request->request->get('_token'))) {
            $historiquesRepository->remove($historique, true);
        }

        return $this->redirectToRoute('app_admin_historiques_index', [], Response::HTTP_SEE_OTHER);
    }
}
