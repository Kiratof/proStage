<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProStageController extends AbstractController
{
    
    public function index()
    {
        return $this->render('pro_stage/index.html.twig');
    }

    public function brutEntreprises()
    {
        return new Response('<html><body><h1> Cette page affichera la liste des entreprises proposant un stage </h1></body></html>' );
    }

    public function brutFormations()
    {
        return new Response('<html><body><h1> Cette page affichera la liste des formations de l\'IUTs </h1></body></html>' );
    }

    public function brutStage($id)
    {
        return new Response('<html><body><h1> Cette page affichera le descriptif du stage ayant pour identifiant '. $id . ' </h1></body></html>' );
    }



}
