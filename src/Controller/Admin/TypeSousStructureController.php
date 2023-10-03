<?php

namespace App\Controller\Admin;

use App\Entity\TypeSousStructure;
use App\Form\TypeSousStructureType;
use App\Repository\TypeSousStructureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type_sous_structure')]
//#[IsGranted("ROLE_SUPER_ADMIN")]
class TypeSousStructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_sous_structure_index', methods: ['GET'])]
    public function index(TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        return $this->render('admin/type_sous_structure/index.html.twig', [
            'type_sous_structures' => $typeSousStructureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_type_sous_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $typeSousStructure = new TypeSousStructure();
        $form = $this->createForm(TypeSousStructureType::class, $typeSousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeSousStructureRepository->save($typeSousStructure, true);

            return $this->redirectToRoute('app_admin_type_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_sous_structure/new.html.twig', [
            'type_sous_structure' => $typeSousStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_sous_structure_show', methods: ['GET'])]
    public function show(TypeSousStructure $typeSousStructure): Response
    {
        return $this->render('admin/type_sous_structure/show.html.twig', [
            'type_sous_structure' => $typeSousStructure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_sous_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeSousStructure $typeSousStructure, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $form = $this->createForm(TypeSousStructureType::class, $typeSousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeSousStructureRepository->save($typeSousStructure, true);

            return $this->redirectToRoute('app_admin_type_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_sous_structure/edit.html.twig', [
            'type_sous_structure' => $typeSousStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_sous_structure_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, TypeSousStructure $typeSousStructure, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeSousStructure->getId(), $request->request->get('_token'))) {
            $typeSousStructureRepository->remove($typeSousStructure, true);
        }
        return $this->render('admin/type_sous_structure/delete.html.twig',[
            'type_sous_structure'=>$typeSousStructure,
        ]);
    }
}
