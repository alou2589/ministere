<?php

namespace App\Controller\Admin;

use App\Entity\CategorieMateriel;
use App\Form\CategorieMaterielType;
use App\Repository\CategorieMaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin/categorie_materiel')]
#[IsGranted("ROLE_INFO_ADMIN")]
class CategorieMaterielController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_materiel_index', methods: ['GET'])]
    public function index(CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        return $this->render('admin/categorie_materiel/index.html.twig', [
            'categorie_materiels' => $categorieMaterielRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        $categorieMateriel = new CategorieMateriel();
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->save($categorieMateriel, true);

            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie_materiel/new.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_materiel_show', methods: ['GET'])]
    public function show(CategorieMateriel $categorieMateriel): Response
    {
        return $this->render('admin/categorie_materiel/show.html.twig', [
            'categorie_materiel' => $categorieMateriel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->save($categorieMateriel, true);

            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/categorie_materiel/edit.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_categorie_materiel_delete', methods: ['GET','POST'])]
    public function delete(Request $request, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieMateriel->getId(), $request->request->get('_token'))) {
            $categorieMaterielRepository->remove($categorieMateriel, true);
            return $this->redirectToRoute('app_admin_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/categorie_materiel/delete.html.twig',[
            'categorie_materiel'=>$categorieMateriel,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_categorie_materiel_liste', methods: ['GET', 'POST'])]
    public function listepc(CategorieMateriel $categorieMateriel)
    {
        return $this->render('admin/categorie_materiel/liste.html.twig',[
            'categorie_materiel'=>$categorieMateriel,
        ]);
    }
}
