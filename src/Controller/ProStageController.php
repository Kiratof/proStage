<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\StageRepository;
use App\Entity\Stage;

class ProStageController extends AbstractController
{
    
    public function index(StageRepository $repo) 
    {
        $stages = $repo->findAll();
        return $this->render('pro_stage/index.html.twig', ["stages" => $stages]);
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

    public function ajoutStage()
    {
        $stage = new Stage();

        $formulaireStage = $this->createFormBuilder($stage)
        ->add('titre')
        ->add('description')
        ->add('missions')
        ->add('email')
        ->getForm();

        return $this->render('pro_stage/ajoutStage.html.twig', ['vueFormulaire' => $formulaireStage->createView()]);
    }


}
