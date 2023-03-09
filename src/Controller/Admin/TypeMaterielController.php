<?php

namespace App\Controller\Admin;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use App\Repository\TypeMaterielRepository;
use DeepCopy\TypeMatcher\TypeMatcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type_materiel')]
#[IsGranted("ROLE_INFO_ADMIN")]
class TypeMaterielController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_materiel_index', methods: ['GET'])]
    public function index(TypeMaterielRepository $typeMaterielRepository): Response
    {
        return $this->render('admin/type_materiel/index.html.twig', [
            'type_materiels' => $typeMaterielRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_type_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeMaterielRepository $typeMaterielRepository): Response
    {
        $typeMateriel = new TypeMateriel();
        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMaterielRepository->save($typeMateriel, true);

            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_materiel/new.html.twig', [
            'type_materiel' => $typeMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_materiel_show', methods: ['GET'])]
    public function show(TypeMateriel $typeMateriel): Response
    {
        return $this->render('admin/type_materiel/show.html.twig', [
            'type_materiel' => $typeMateriel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeMateriel $typeMateriel, TypeMaterielRepository $typeMaterielRepository): Response
    {
        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeMaterielRepository->save($typeMateriel, true);

            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_materiel/edit.html.twig', [
            'type_materiel' => $typeMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_materiel_delete', methods: ['GET','POST'])]
    public function delete(Request $request, TypeMateriel $typeMateriel, TypeMaterielRepository $typeMaterielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeMateriel->getId(), $request->request->get('_token'))) {
            $typeMaterielRepository->remove($typeMateriel, true);
            return $this->redirectToRoute('app_admin_type_materiel_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_materiel/delete.html.twig',[
            'type_materiel'=>$typeMateriel,
        ]);

    }

    #[Route('/{id}/liste', name: 'app_admin_type_materiel_liste', methods: ['GET','POST'])]
    public function listepc(TypeMateriel $typeMateriel)
    {
        return $this->render('admin/type_materiel/liste.html.twig',[
            'type_materiel'=>$typeMateriel,
        ]);
    }
}
