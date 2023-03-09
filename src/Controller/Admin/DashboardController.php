<?php

namespace App\Controller\Admin;

use App\Repository\AgentRepository;
use App\Repository\SousStructureRepository;
use App\Repository\StructureRepository;
use App\Repository\TypeSousStructureRepository;
use App\Repository\TypeStructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(AgentRepository $agentRepository, StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository, 
                        TypeStructureRepository $typeStructureRepository, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $agents = $agentRepository->findAll();
        $typeStructures = $typeStructureRepository->findAll();
        $typeSousStructures = $typeSousStructureRepository->findAll();
        $structures = $structureRepository->findAll();
        $sousStructures = $sousStructureRepository->findAll();
        return $this->render('admin/dashboard/index.html.twig', [
            'agents' => $agents,
            'structures' => $structures,
            'type_structures' => $typeStructures,
            'type_sous_structures' => $typeSousStructures,
            'sous_structures' => $sousStructures,
        ]);
    }
}
