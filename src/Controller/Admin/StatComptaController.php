<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


//#[IsGranted("ROLE_GESTION_ADMIN")]
class StatComptaController extends AbstractController
{
    #[Route('/admin/stat/compta', name: 'app_admin_stat_compta')]
    public function index(): Response
    {
        return $this->render('admin/stat_compta/index.html.twig', [
            'controller_name' => 'StatComptaController',
        ]);
    }
}
