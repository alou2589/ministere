<?php

namespace App\Controller\Admin;

use App\Entity\HistoriqueRH;
use App\Repository\HistoriqueRHRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/historique_rh')]
class HistoriqueRHController extends AbstractController
{
    #[Route('/', name: 'app_admin_historique_rh_index', methods: ['GET'])]
    public function index(HistoriqueRHRepository $historiqueRHRepository): Response
    {
        return $this->render('admin/historique_rh/index.html.twig', [
            'historique_rhs' => $historiqueRHRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_historique_rh_show', methods: ['GET'])]
    public function show(HistoriqueRH $historiqueRH): Response
    {
        return $this->render('admin/historique_rh/show.html.twig', [
            'historique_rh' => $historiqueRH,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_historique_rh_delete', methods: ['POST'])]
    public function delete(Request $request, HistoriqueRH $historiqueRH, HistoriqueRHRepository $historiqueRHRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historiqueRH->getId(), $request->request->get('_token'))) {
            $historiqueRHRepository->remove($historiqueRH, true);
        }

        return $this->redirectToRoute('app_admin_historique_rh_index', [], Response::HTTP_SEE_OTHER);
    }
}
