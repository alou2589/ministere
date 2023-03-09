<?php

namespace App\Controller\Admin;

use App\Entity\TypeStructure;
use App\Form\TypeStructureType;
use App\Repository\TypeStructureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/type_structure')]
#[IsGranted("ROLE_SUPER_ADMIN")]
class TypeStructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_type_structure_index', methods: ['GET'])]
    public function index(TypeStructureRepository $typeStructureRepository): Response
    {
        return $this->render('admin/type_structure/index.html.twig', [
            'type_structures' => $typeStructureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_type_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeStructureRepository $typeStructureRepository): Response
    {
        $typeStructure = new TypeStructure();
        $form = $this->createForm(TypeStructureType::class, $typeStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeStructureRepository->save($typeStructure, true);

            return $this->redirectToRoute('app_admin_type_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_structure/new.html.twig', [
            'type_structure' => $typeStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_structure_show', methods: ['GET'])]
    public function show(TypeStructure $typeStructure): Response
    {
        return $this->render('admin/type_structure/show.html.twig', [
            'type_structure' => $typeStructure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeStructure $typeStructure, TypeStructureRepository $typeStructureRepository): Response
    {
        $form = $this->createForm(TypeStructureType::class, $typeStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeStructureRepository->save($typeStructure, true);

            return $this->redirectToRoute('app_admin_type_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/type_structure/edit.html.twig', [
            'type_structure' => $typeStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_type_structure_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, TypeStructure $typeStructure, TypeStructureRepository $typeStructureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeStructure->getId(), $request->request->get('_token'))) {
            $typeStructureRepository->remove($typeStructure, true);
            return $this->redirectToRoute('app_admin_type_structure_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/type_structure/delete.html.twig',[
            'type_structure'=>$typeStructure,
        ]);

    }
}
