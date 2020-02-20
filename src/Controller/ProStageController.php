<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\StageRepository;
use App\Entity\Stage;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


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
        ->add('titre', TextType::class)
        ->add('description', TextareaType::class)
        ->add('missions', TextareaType::class)
        ->add('email', EmailType::class)
        ->getForm();

        return $this->render('pro_stage/ajoutStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView()]);
    }


}
