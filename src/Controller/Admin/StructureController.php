<?php

namespace App\Controller\Admin;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/structure')]
class StructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_structure_index', methods: ['GET'])]
    public function index(StructureRepository $structureRepository): Response
    {
        return $this->render('admin/structure/index.html.twig', [
            'structures' => $structureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_structure_new', methods: ['GET', 'POST'])]
    //#[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request, StructureRepository $structureRepository): Response
    {
        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->save($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/structure/new.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_structure_show', methods: ['GET'])]
    public function show(Structure $structure): Response
    {
        return $this->render('admin/structure/show.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_structure_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->save($structure, true);

            return $this->redirectToRoute('app_admin_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/structure/edit.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_structure_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->request->get('_token'))) {
            $structureRepository->remove($structure, true);
        }

        return $this->render('admin/structure/delete.html.twig',[
            'structure'=>$structure,
        ]);
    }
    
    #[Route('/{id}/show_services', name: 'app_admin_structure_show_services', methods: ['GET'])]
    public function show_services(Structure $structure)
    {
        return $this->render('admin/structure/show_services.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route('/{id}/show_agents', name: 'app_admin_structure_show_agents', methods: ['GET'])]
    public function show_agents(Structure $structure): Response
    {
        return $this->render('admin/structure/show_agents.html.twig',[
            'structure'=>$structure,
        ]);
    }
}
