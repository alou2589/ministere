<?php

namespace App\Controller\Admin;

use App\Repository\AgentRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\MaterielRepository;
use App\Repository\MessagesRepository;
use App\Repository\StructureRepository;
use App\Repository\TypeAgentRepository;
use App\Repository\AttributionRepository;
use App\Repository\MaintenanceRepository;
use App\Repository\MarqueMatosRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeMaterielRepository;
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
 
    #[Route('/admin/dashboard_info', name: 'app_admin_dashboard_info')]
    public function dash_info(MaterielRepository $materielRepository,MaintenanceRepository $maintenanceRepository,TypeMaterielRepository $typeMaterielRepository,
    MessagesRepository $messagesRepository,NotificationRepository $notificationRepository,MarqueMatosRepository $marqueMatosRepository,AttributionRepository $attributionRepository, ChartBuilderInterface $cahertbuilderAY,
    ChartBuilderInterface $chartbuilderTM,ChartBuilderInterface $chartbuilderDY,ChartBuilderInterface $chartbuilderMY ,ChartBuilderInterface $chartbuilderMM, ChartBuilderInterface $chartbuilderSM): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $laptop=$typeMaterielRepository->laptops();
        $desktop=$typeMaterielRepository->desktops();
        $aio=$typeMaterielRepository->aios();
        $printerColor=$typeMaterielRepository->printerColors();
        $printerNB=$typeMaterielRepository->printerNBs();
        $photocopieuse=$typeMaterielRepository->photocopieuses();
        
        //Ordinateur Portable
        $laptopAttribs=$attributionRepository->matosAttrib('Ordinateur Portable');
        $laptopAmortis=$maintenanceRepository->matosStatus('Ordinateur Portable','Amorti');
        $laptopEnPannes=$maintenanceRepository->matosStatus('Ordinateur Portable','En Panne');
        $laptopsByYears=$materielRepository->matosByYear("Ordinateur Portable");
        
        //Ordniateur Fixe
        $desktopAttribs=$attributionRepository->matosAttrib('Ordinateur Fixe');
        $desktopAmortis=$maintenanceRepository->matosStatus('Ordinateur Fixe','Amorti');
        $desktopEnPannes=$maintenanceRepository->matosStatus('Ordinateur Fixe','En Panne');
        $desktopsByYears=$materielRepository->matosByYear(["Ordinateur Fixe","All In One"]);
        
        //All In One
        $aioAttribs=$attributionRepository->matosAttrib('All In One');
        $aioAmortis=$maintenanceRepository->matosStatus('All In One','Amorti');
        $aioEnPannes=$maintenanceRepository->matosStatus('All In One','En Panne');
        
        //Imprimante NB & Colors & Photocopieuse
        $printerColorAttribs=$attributionRepository->matosAttrib('Imprimante Couleur');
        $printerColorAmortis=$maintenanceRepository->matosStatus('Imprimante Couleur','Amorti');
        $printerColorEnPannes=$maintenanceRepository->matosStatus('Imprimante Couleur','En Panne');
        
        $printerNBAttribs=$attributionRepository->matosAttrib('Imprimante Noir et Blanc');
        $printerNBAmortis=$maintenanceRepository->matosStatus('Imprimante Noir et Blanc','Amorti');
        $printerNBEnPannes=$maintenanceRepository->matosStatus('Imprimante Noir et Blanc','En Panne');
        
        $photocopieuseAttribs=$attributionRepository->matosAttrib('Photocpieuse Multifonction');
        $photocopieuseAmortis=$maintenanceRepository->matosStatus('Photocpieuse Multifonction','Amorti');
        $photocopieuseEnPannes=$maintenanceRepository->matosStatus('Photocpieuse Multifonction','En Panne');
        
        $attributions=$attributionRepository->findAll();
        $materiels=$materielRepository->findAll();
        
        $typeMateriels = $typeMaterielRepository->findAll();
        $marqueMatos = $marqueMatosRepository->findAll();
        $attribByYears = $attributionRepository->attribByYear();
        $maintenances_amortis=$maintenanceRepository->findBy(['status_matos'=> 'Amorti']);
        $maintenances_pannes=$maintenanceRepository->findBy(['status_matos'=> 'En Panne']);
        $m_count = array('Amorti' => count($maintenances_amortis),'En Panne'=>count($maintenances_pannes), 'Normal'=>count($materiels)-(count($maintenances_amortis)+count($maintenances_pannes)) );
        
        foreach ($typeMateriels as $typeMateriel) {
            $tm_name[] = $typeMateriel->getNomTypeMatos();
            $tm_matos[] = count($typeMateriel->getMateriels());
        }
        
        foreach ($marqueMatos as $marqueMato) {
            # code...
            $mm_name[] = $marqueMato->getNomMarqueMatos();
            $mm_matos[] = count($marqueMato->getMateriels());
        }
        foreach ($attribByYears as $attribByYear) {
            # code...
            $attribByYear_name[] = $attribByYear['duree_utilisation'];
            $attribByYear_count[] = $attribByYear['nb_attribution'];
        }
        foreach ($laptopsByYears as $laptopsByYear) {
            # code...
            $laptopsByYear_name[] = $laptopsByYear['date_record'];
            $laptopsByYear_count[] = $laptopsByYear['nb_matos'];
        }
        foreach ($desktopsByYears as $desktopsByYear) {
            # code...
            $desktopsByYear_name[] = $desktopsByYear['date_record'];
            $desktopsByYear_count[] = $desktopsByYear['nb_matos'];
        }
        $chartLY = self::statistiques($chartbuilderMY, Chart::TYPE_LINE,$laptopsByYear_name, $laptopsByYear_count,'Évolution par Année', $materiels );
        $chartDY = self::statistiques($chartbuilderDY, Chart::TYPE_LINE,$desktopsByYear_name, $desktopsByYear_count,'Évolution par Année', $materiels );
        $chartTM = self::statistiques($chartbuilderTM, Chart::TYPE_PIE,$tm_name, $tm_matos,'Matériels Par Type', $typeMateriels );
        $chartMM = self::statistiques($chartbuilderMM, Chart::TYPE_PIE, $mm_name,$mm_matos, 'Matériel par Marque', $marqueMatos);
        $chartAY = self::statistiques($cahertbuilderAY, Chart::TYPE_BAR, $attribByYear_name, $attribByYear_count, 'Attribution par année',$attribByYears );
        $chartSM = self::statistiques($chartbuilderSM, Chart::TYPE_BAR,['Amorti', 'En Panne', 'Normal'], $m_count, 'Etat du parc',$materiels);

        return $this->render('admin/dashboard/info_index.html.twig', [
            'laptops' => $laptop->getMateriels(),
            'laptopAttribs'=>$laptopAttribs,
            'laptopAmortis'=>$laptopAmortis,
            'laptopEnPannes'=>$laptopEnPannes,
            'desktops' => $desktop->getMateriels(),
            'desktopAttribs'=>$desktopAttribs,
            'desktopAmortis'=>$desktopAmortis,
            'desktopEnPannes'=>$desktopEnPannes, 
            'aios' => $aio->getMateriels(), 
            'aioAttribs'=>$aioAttribs,
            'aioAmortis'=>$aioAmortis,
            'aioEnPannes'=>$aioEnPannes,
            
            'printerColorAttribs'=>$printerColorAttribs,
            'printerColorAmortis'=>$printerColorAmortis,
            'printerColorEnPannes'=>$printerColorEnPannes, 
            
            'printerNBAttribs'=>$printerNBAttribs,
            'printerNBAmortis'=>$printerNBAmortis,
            'printerNBEnPannes'=>$printerNBEnPannes, 
            
            'photocopieuseAttribs'=>$photocopieuseAttribs,
            'photocopieuseAmortis'=>$photocopieuseAmortis,
            'photocopieuseEnPannes'=>$photocopieuseEnPannes, 
            
            'printerColors' => $printerColor->getMateriels(), 
            'printerNBs' => $printerNB->getMateriels(), 
            'photocopieuses' => $photocopieuse->getMateriels(), 
            'attributions' => $attributions, 
            'materiels' => $materiels, 
            'maintenances_amortis' => $maintenances_amortis, 
            'maintenances_pannes' => $maintenances_pannes, 
            'chartLY' => $chartLY, 
            'chartDY' => $chartDY, 
            'chartTM' => $chartTM, 
            'chartMM'=>$chartMM,
            'chartAY'=>$chartAY,
            'chartSM'=>$chartSM,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
    #[Route('/admin/dashboard_perso', name: 'app_admin_dashboard_perso')]
    public function dash_perso(NotificationRepository $notificationRepository,MessagesRepository $messagesRepository,ChartBuilderInterface $chartBuilderSA,ChartBuilderInterface $chartBuilderRY, ChartBuilderInterface $chartBuilderDA,ChartBuilderInterface $chartbuilderSTA ,ChartBuilderInterface $chartBuilderAS,AgentRepository $agentRepository, StructureRepository $structureRepository, SousStructureRepository $sousStructureRepository, 
                        StatutAgentRepository $statutAgentRepository,TypeAgentRepository $typeAgentRepository,TypeStructureRepository $typeStructureRepository, TypeSousStructureRepository $typeSousStructureRepository): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $agents = $agentRepository->findAll();
        $typeAgents=$typeAgentRepository->findAll();
        $agentByYears = $agentRepository->agentByYear();
        $femmes=$agentRepository->findBy(['genre'=>'femme']);
        $hommes=$agentRepository->findBy(['genre'=>'homme']);
        $typeStructures = $typeStructureRepository->findAll();
        $typeSousStructures = $typeSousStructureRepository->findAll();
        $structures = $structureRepository->findAll();
        $sousStructures = $sousStructureRepository->findAll();
        $statutAgents=$statutAgentRepository->statutAgentByYear();
        
        foreach ($typeAgents as $typeAgent) {
            # code...
            $type_name[]=$typeAgent->getNomTypeAgent();
            $type_count[]=count($typeAgent->getAgents());
        }
        
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
         foreach($sousStructures as $sousStructure) {
            # code...
            $ss_name[]=$sousStructure->getNomSousStructure();
            $ss_agents[]=count($sousStructure->getAgents());
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
        
        $chartSA = self::statistiques($chartBuilderSA, Chart::TYPE_BAR,$ss_name, $ss_agents,'Agent Par Sous Structure', $sousStructures );
        $chartDA = self::statistiques($chartBuilderDA, Chart::TYPE_BAR, $s_name, $nbagents, 'Agents par Structure', $structures);
        $chartAS = self::statistiques($chartBuilderAS, Chart::TYPE_DOUGHNUT, ['Homme', 'Femme'], [count($hommes), count($femmes)], 'Agents par Genre', $agents);
        $chartSTA = self::statistiques($chartbuilderSTA, Chart::TYPE_LINE,$sta_name, $sta_count, 'Evolution Agent',$sta_count);
        $chartRY = self::statistiques($chartBuilderRY, Chart::TYPE_DOUGHNUT, $year, $nb_recrus, "Tranche d'âge", $agentByYears);


        return $this->render('admin/dashboard/perso_index.html.twig', [
            'agents' => $agents,
            'hommes' => $hommes,
            'femmes' => $femmes,
            'typeAgents' => $typeAgents,
            'chartSA' => $chartSA,
            'chartDA' => $chartDA,
            'chartAS' => $chartAS,
            'chartSTA' => $chartSTA,
            'chartRY' => $chartRY,
            'structures' => $structures,
            'type_structures' => $typeStructures,
            'type_sous_structures' => $typeSousStructures,
            'sous_structures' => $sousStructures,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
