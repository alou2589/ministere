<?php

namespace App\Controller\Admin;

use App\Entity\StatutAgent;
use App\Repository\AffectationRepository;
use App\Repository\AgentRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\MessagesRepository;
use App\Repository\StructureRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\NotificationRepository;
use App\Repository\SousStructureRepository;
use App\Repository\TypeAgentRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
   public function index(ChartBuilderInterface $chartBuilderRY, ChartBuilderInterface $chartBuilderAT,MessagesRepository $messagesRepository,ChartBuilderInterface $chartBuilderSA,ChartBuilderInterface $chartBuilderDA,ChartBuilderInterface $chartBuilderSD,ChartBuilderInterface $chartBuilderAS,
    AgentRepository $agentRepository, AffectationRepository $affectationRepository,TypeAgentRepository $typeAgentRepository,StatutAgentRepository $statutAgentRepository,StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository,NotificationRepository $notificationRepository, ChartBuilderInterface $chartbuilderSTA): Response
      { 
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $sousStructures=$sousStructureRepository->findAll();
        $structures=$structureRepository->findAll();
        $typeAgents=$typeAgentRepository->findAll();
        $agents = $agentRepository->findAll();
        $agentByYears = $agentRepository->agentByYear();
        $masculins[]=count($agentRepository->findBy(['genre'=>'homme']));
        $feminins[]=count($agentRepository->findBy(['genre'=>'femme']));
        $statutAgents=$statutAgentRepository->statutAgentByYear();

        foreach ($structures as $structure) {
            # code...
            $s_name[] = $structure->getNomStructure();
            $s_ss[] = count($structure->getSousStructures());
            $s_agents = $affectationRepository->affectation_structure($structure->getId());
            foreach ($s_agents as $s_agent) {
               # code...
               $nbagents[] = $s_agent['agents'];
            }
         }
         
         foreach ($typeAgents as $typeAgent) {
            # code...
            $type_name[]=$typeAgent->getNomTypeAgent();
            $type_count[]=count($typeAgent->getStatutAgents());
         }
         foreach ($statutAgents as $statutAgent) {
             # code...
             $sta_name[] = $statutAgent['date_record'];
             $sta_count[] = $statutAgent['nb_agents'];
         }
         foreach ($agentByYears as $agentByYear) {
            # code...
            $year[] = $agentByYear['tranche_age'];
            $nb_recrus[] = $agentByYear['nb_agents'];
         }
         foreach($sousStructures as $sousStructure) {
            # code...
            $ss_name[]=$sousStructure->getNomSousStructure();
            $ss_agents[]=count($sousStructure->getAffectations());
         }
        $chartAT = self::statistiques($chartBuilderAT, Chart::TYPE_PIE,$type_name, $type_count,'Agent Par Statut', $agents);
        $chartSA = self::statistiques($chartBuilderSA, Chart::TYPE_BAR,$ss_name, $ss_agents,'Agent Par Sous Structure', $sousStructures );
        $chartDA = self::statistiques($chartBuilderDA, Chart::TYPE_BAR, $s_name, $nbagents, 'Agents par Structure', $structures);
        $chartSD = self::statistiques($chartBuilderSD, Chart::TYPE_PIE, $s_name, $s_ss, 'SousStructure par Structure', $structures);
        $chartRY = self::statistiques($chartBuilderRY, Chart::TYPE_BAR, $year, $nb_recrus, "Tranche d'âge", $agentByYears);
        $chartAS = self::statistiques($chartBuilderAS, Chart::TYPE_PIE, ['Homme', 'Femme'], [$masculins, $feminins], 'Agents par Genre', $agents);
        $chartSTA = self::statistiques($chartbuilderSTA, Chart::TYPE_LINE,$sta_name, $sta_count, 'Evolution Agent',$sta_count);
 
         return $this->render('admin/stat_personnel/index.html.twig', [ 
                'chartSA' => $chartSA, 
                'chartAT' => $chartAT, 
                'chartDA' => $chartDA, 
                'chartSD' => $chartSD, 
                'chartAS' => $chartAS, 
                'chartRY' => $chartRY, 
                'chartSTA'=>$chartSTA,
                'sta_name'=>$sta_name,
                'notifications' => $notifications,
                'messages' => $messages,
                'agentByYears' => $agentByYears,
            ]); 
      } 
}
