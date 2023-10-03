<?php

namespace App\Controller\Admin;

use App\Entity\SousStructure;
use App\Form\SousStructureType;
use App\Repository\SousStructureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sous_structure')]
class SousStructureController extends AbstractController
{
    #[Route('/', name: 'app_admin_sous_structure_index', methods: ['GET'])]
    public function index(SousStructureRepository $sousStructureRepository): Response
    {
        return $this->render('admin/sous_structure/index.html.twig', [
            'sous_structures' => $sousStructureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_sous_structure_new', methods: ['GET', 'POST'])]
    //#[IsGranted("ROLE_RH_ADMIN")]
    public function new(Request $request, SousStructureRepository $sousStructureRepository): Response
    {
        $sousStructure = new SousStructure();
        $form = $this->createForm(SousStructureType::class, $sousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousStructureRepository->save($sousStructure, true);

            return $this->redirectToRoute('app_admin_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sous_structure/new.html.twig', [
            'sous_structure' => $sousStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sous_structure_show', methods: ['GET'])]
    public function show(SousStructure $sousStructure): Response
    {
        return $this->render('admin/sous_structure/show.html.twig', [
            'sous_structure' => $sousStructure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sous_structure_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function edit(Request $request, SousStructure $sousStructure, SousStructureRepository $sousStructureRepository): Response
    {
        $form = $this->createForm(SousStructureType::class, $sousStructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sousStructureRepository->save($sousStructure, true);

            return $this->redirectToRoute('app_admin_sous_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/sous_structure/edit.html.twig', [
            'sous_structure' => $sousStructure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_sous_structure_delete', methods: ['GET','POST'])]
    #[IsGranted("ROLE_RH_ADMIN")]
    public function delete(Request $request, SousStructure $sousStructure, SousStructureRepository $sousStructureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousStructure->getId(), $request->request->get('_token'))) {
            $sousStructureRepository->remove($sousStructure, true);
        }
        return $this->render('admin/sous_structure/delete.html.twig',[
            'sous_structure'=>$sousStructure
        ]);
    }

    #[Route('/{id}/show_agents', name: 'app_admin_sous_structure_show_agents', methods: ['GET'])]
    public function show_agents(SousStructure $sous_structure): Response
    {
        return $this->render('admin/sous_structure/show_agents.html.twig',[
            'sous_structure'=>$sous_structure,
        ]);
    }
}
