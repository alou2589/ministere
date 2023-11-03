<?php

namespace App\Controller\Admin;

use App\Repository\AgentRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\MessagesRepository;
use App\Repository\StructureRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\NotificationRepository;
use App\Repository\SousStructureRepository;
use App\Repository\TypeStructureRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TypeSousStructureRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{

    public function getRandomColor($nb_colors)
    {
        $colors = [];
        for ($i = 0; $i < $nb_colors; $i++) {
            # code...
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            $color = 'rgb(' . $r . ',' . $g . ',' . $b . ')';
            array_push($colors, $color);
        }
        return $colors;
    }
 
    public function statistiques($chartBuilder, $charttype, $label_name, $data_value,$label, $nb)
    {
        $mychart = $chartBuilder->createChart($charttype);
        $mychart->setData([
            'labels' => $label_name,
            'datasets' => [
                [
                    'label' => $label,
                    'backgroundColor' => self::getRandomColor(count($nb)),
                    'data' => $data_value,
                ],
            ],
        ]);
        $mychart->setOptions([
            'title' => [
                'display' => true,
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                ],
            ],
        ]);
 
        return $mychart;
    }
 
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function dash_perso(NotificationRepository $notificationRepository,MessagesRepository $messagesRepository,ChartBuilderInterface $chartbuilderSTA ,ChartBuilderInterface $chartBuilderAS,AgentRepository $agentRepository, StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository, 
                        StatutAgentRepository $statutAgentRepository,TypeStructureRepository $typeStructureRepository, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $agents = $agentRepository->findAll();
        $femmes=$agentRepository->findBy(['genre'=>'femme']);
        $hommes=$agentRepository->findBy(['genre'=>'homme']);
        $typeStructures = $typeStructureRepository->findAll();
        $typeSousStructures = $typeSousStructureRepository->findAll();
        $structures = $structureRepository->findAll();
        $sousStructures = $sousStructureRepository->findAll();
        $statutAgents=$statutAgentRepository->statutAgentByYear();
        
        
        foreach ($statutAgents as $statutAgent) {
            # code...
            $sta_name[] = $statutAgent['date_record'];
            $sta_count[] = $statutAgent['nb_agents'];
        }
        
        $chartAS = self::statistiques($chartBuilderAS, Chart::TYPE_PIE, ['Homme', 'Femme'], [count($hommes), count($femmes)], 'Agents par Genre', $agents);
        $chartSTA = self::statistiques($chartbuilderSTA, Chart::TYPE_LINE,$sta_name, $sta_count, 'Evolution Agent',$sta_count);


        return $this->render('admin/dashboard/index.html.twig', [
            'agents' => $agents,
            'hommes' => $hommes,
            'femmes' => $femmes,
            'chartAS' => $chartAS,
            'chartSTA' => $chartSTA,
            'structures' => $structures,
            'type_structures' => $typeStructures,
            'type_sous_structures' => $typeSousStructures,
            'sous_structures' => $sousStructures,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
