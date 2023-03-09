<?php

namespace App\Controller\Admin;

use App\Entity\StatutAgent;
use App\Repository\AgentRepository;
use App\Repository\SousStructureRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\StructureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilder;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/admin/stat_personnel')]
#[IsGranted("ROLE_RH_ADMIN")]
class StatPersonnelController extends AbstractController
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

   #[Route('/service_agents', name: 'app_admin_stat_personnel_service')]
   public function index(ChartBuilderInterface $chartBuilderRY,ChartBuilderInterface $chartBuilderSA,ChartBuilderInterface $chartBuilderDA,ChartBuilderInterface $chartBuilderSD,ChartBuilderInterface $chartBuilderAS,
    AgentRepository $agentRepository,StatutAgentRepository $statutRepository,StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository): Response 
      { 
        $sousStructures=$sousStructureRepository->findAll();
        $structures=$structureRepository->findAll();
        $agents = $agentRepository->findAll();
        $agentByYears = $statutRepository->agentByYear();
        $masculins[]=count($agentRepository->findBy(['genre'=>'homme']));
        $feminins[]=count($agentRepository->findBy(['genre'=>'femme']));
        foreach ($structures as $structure) {
            # code...
            $s_name[] = $structure->getNomStructure();
            $s_ss[] = count($structure->getSousStructures());
            $s_agents = $agentRepository->agents_structure($structure->getId());
            foreach ($s_agents as $s_agent) {
               # code...
               $nbagents[] = $s_agent['agents'];
            }
         }
         foreach ($agentByYears as $agentByYear) {
            # code...
            $year[] = $agentByYear['date_record'];
            $nb_recrus[] = $agentByYear['nb_agents'];
         }
         foreach($sousStructures as $sousStructure) {
            # code...
            $ss_name[]=$sousStructure->getNomSousStructure();
            $ss_agents[]=count($sousStructure->getAgents());
         }
        $chartSA = self::statistiques($chartBuilderSA, Chart::TYPE_PIE,$ss_name, $ss_agents,'Agent Par Sous Structure', $sousStructures );
        $chartDA = self::statistiques($chartBuilderDA, Chart::TYPE_PIE, $s_name, $nbagents, 'Agents par Structure', $structures);
        $chartSD = self::statistiques($chartBuilderSD, Chart::TYPE_PIE, $s_name, $s_ss, 'SousStructure par Structure', $structures);
        $chartRY = self::statistiques($chartBuilderRY, Chart::TYPE_BAR, $year, $nb_recrus, 'Agent par Année', $agentByYears);
        $chartAS = self::statistiques($chartBuilderAS, Chart::TYPE_PIE, ['Homme', 'Femme'], [$masculins, $feminins], 'Agents par Genre', $agents);
         
         return $this->render('admin/stat_personnel/index.html.twig', [ 
                'chartSA' => $chartSA, 
                'chartDA' => $chartDA, 
                'chartSD' => $chartSD, 
                'chartAS' => $chartAS, 
                'chartRY' => $chartRY, 
            ]); 
      } 
}
