<?php

namespace App\Controller\Admin;

use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\MessagesRepository;
use App\Repository\AttributionRepository;
use App\Repository\MarqueMatosRepository;
use App\Repository\NotificationRepository;
use App\Repository\TypeMaterielRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    public function index(TypeMaterielRepository $typeMaterielRepository,MessagesRepository $messagesRepository,NotificationRepository $notificationRepository,MarqueMatosRepository $marqueMatosRepository,AttributionRepository $attributionRepository, ChartBuilderInterface $cahertbuilderAY, ChartBuilderInterface $chartbuilderTM, ChartBuilderInterface $chartbuilderMM): Response
    {
        $messages= $messagesRepository->findBy(['status'=>'Non Lu', 'destinataire'=>$this->getUser()]);
        $notifications= $notificationRepository->findBy(['status'=>false]);
        $typeMateriels = $typeMaterielRepository->findAll();
        $marqueMatos = $marqueMatosRepository->findAll();
        $attribByYears = $attributionRepository->attribByYear();
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
            $attribByYear_name[] = $attribByYear['annee_attrib'];
            $attribByYear_count[] = $attribByYear['nb_attribution'];
        }
        $chartTM = self::statistiques($chartbuilderTM, Chart::TYPE_PIE,$tm_name, $tm_matos,'Matériels Par Type', $typeMateriels );
        $chartMM = self::statistiques($chartbuilderMM, Chart::TYPE_PIE, $mm_name,$mm_matos, 'Matériel par Marque', $marqueMatos);
        $chartAY = self::statistiques($cahertbuilderAY, Chart::TYPE_PIE, $attribByYear_name, $attribByYear_count, 'Attribution par année',$attribByYears );
        return $this->render('admin/stat_informatique/index.html.twig', [
            'chartTM' => $chartTM, 
            'chartMM'=>$chartMM,
            'chartAY'=>$chartAY,
            'notifications' => $notifications,
            'messages' => $messages,
        ]);
    }
}
