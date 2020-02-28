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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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

    public function ajoutStage(Request $request, ObjectManager $manager)
    {
        $stage = new Stage();

        $formulaireStage = $this->createFormBuilder($stage)
        ->add('titre', TextType::class)
        ->add('description', TextareaType::class)
        ->add('missions', TextareaType::class)
        ->add('email', EmailType::class)
        ->getForm();

        $formulaireStage->handleRequest($request);

        if($formulaireStage->isSubmitted()){
            //Enregistrer la ressource en BD
            $manager->persist($stage);
            $manager->flush();

            //Ramener l'user à la page d'accueil
            return $this->redirectToRoute('proStage_accueil');

        }

        return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView(), 'action' => "ajouter"]);
    }

    public function modifStage(Request $request, ObjectManager $manager, Stage $stage)
    {
        $formulaireStage = $this->createFormBuilder($stage)
        ->add('titre', TextType::class)
        ->add('description', TextareaType::class)
        ->add('missions', TextareaType::class)
        ->add('email', EmailType::class)
        ->getForm();

        $formulaireStage->handleRequest($request);

        if($formulaireStage->isSubmitted()){
            //Enregistrer la ressource en BD
            $manager->persist($stage);
            $manager->flush();

            //Ramener l'user à la page d'accueil
            return $this->redirectToRoute('proStage_accueil');

        }

        return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView(), 'action' => "modifier"]);
    }


}
