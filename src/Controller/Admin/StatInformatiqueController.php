<?php

namespace App\Controller\Admin;

use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\MessagesRepository;
use App\Repository\AttributionRepository;
use App\Repository\MaintenanceRepository;
use App\Repository\MarqueMatosRepository;
use App\Repository\MaterielRepository;
use App\Repository\NotificationRepository;
use App\Repository\StatutAgentRepository;
use App\Repository\TypeMaterielRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_INFO_ADMIN")]
class StatInformatiqueController extends AbstractController
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

    #[Route('/admin/stat_informatique', name: 'app_admin_stat_informatique')]
    public function index(StatutAgentRepository $statutAgentRepository,MaterielRepository $materielRepository,MaintenanceRepository $maintenanceRepository,TypeMaterielRepository $typeMaterielRepository,
    MessagesRepository $messagesRepository,NotificationRepository $notificationRepository,MarqueMatosRepository $marqueMatosRepository,AttributionRepository $attributionRepository, ChartBuilderInterface $cahertbuilderAY,
    ChartBuilderInterface $chartbuilderTM, ChartBuilderInterface $chartbuilderMM, ChartBuilderInterface $chartbuilderSM): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeMateriels = $typeMaterielRepository->findAll();
        $marqueMatos = $marqueMatosRepository->findAll();
        $attribByYears = $attributionRepository->attribByYear();
        $materiels=$materielRepository->findAll();
        $maintenances_amortis=$maintenanceRepository->findBy(['status_matos'=> 'Amorti']);
        $m_count = array('Amorti' => count($maintenances_amortis),'Normal'=>count($materiels)-count($maintenances_amortis) );
        
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
        $chartTM = self::statistiques($chartbuilderTM, Chart::TYPE_PIE,$tm_name, $tm_matos,'Matériels Par Type', $typeMateriels );
        $chartMM = self::statistiques($chartbuilderMM, Chart::TYPE_PIE, $mm_name,$mm_matos, 'Matériel par Marque', $marqueMatos);
        $chartAY = self::statistiques($cahertbuilderAY, Chart::TYPE_BAR, $attribByYear_name, $attribByYear_count, 'Attribution par année',$attribByYears );
        $chartSM = self::statistiques($chartbuilderSM, Chart::TYPE_BAR,['Amorti', 'Normal'], $m_count, 'Etat du parc',$m_count);

        return $this->render('admin/stat_informatique/index.html.twig', [
            'chartTM' => $chartTM, 
            'chartMM'=>$chartMM,
            'chartAY'=>$chartAY,
            'chartSM'=>$chartSM,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
