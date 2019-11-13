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

    public function affichageEntreprises()
    {
        return $this->render('pro_stage/affichageEntreprises.html.twig');
    }

    public function affichageFormations()
    {
        return $this->render('pro_stage/affichageFormations.html.twig');
    }

    public function affichageStage($id)
    {
        return $this->render('pro_stage/affichageStage.html.twig', ['idRessource' => $id] );
    }



}
