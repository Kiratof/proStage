<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Entity\Stage;
use App\Entity\Entreprise;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\StageType;
use App\Form\EntrepriseType;
class ProStageController extends AbstractController
{
    
    public function index(StageRepository $repo) 
    {
        $stages = $repo->findByDateAjout();
        return $this->render('pro_stage/index.html.twig', ["stages" => $stages]);
    }

    public function affichageEntreprises(EntrepriseRepository $repo)
    {
        $entreprises = $repo->findAll();
        return $this->render('pro_stage/affichageEntreprises.html.twig', ['entreprises' => $entreprises]);
    }

    public function affichageFormations(FormationRepository $repo)
    {
        $formations = $repo->findAll();
        return $this->render('pro_stage/affichageFormations.html.twig', ['formations' => $formations]);
    }

    public function affichageStage($id, StageRepository $repo)
    {
        $stage = $repo->findOneById($id);
        return $this->render('pro_stage/affichageStage.html.twig', ['stage' => $stage] );
    }

    public function ajoutStage(Request $request, ObjectManager $manager)
    {
        $stage = new Stage();

        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($request);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid()){

            // Mémoriser la date d'ajout de la ressources
            $stage->setDateAjout(new \dateTime());

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
        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($request);

        if($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
            //Enregistrer la ressource en BD
            $manager->persist($stage);
            $manager->flush();

            //Ramener l'user à la page d'accueil
            return $this->redirectToRoute('proStage_accueil');

        }

        return $this->render('pro_stage/ajoutModifStage.html.twig', ['vueFormulaireStage' => $formulaireStage->createView(), 'action' => "modifier"]);
    }

    public function affichageStagesParEntreprise($nomEntreprise, StageRepository $repo)
    {
        $stages = $repo->findStagesParEntreprise($nomEntreprise);

        return $this->render('pro_stage/stagesParEntreprise.html.twig', ['stages' => $stages, 'nomEntreprise' => $nomEntreprise]);
    }

    public function affichageStagesParFormation($nomFormation, StageRepository $repo)
    {
        $stages = $repo->findStagesParFormationQB($nomFormation);

        return $this->render('pro_stage/stagesParFormation.html.twig', ['stages' => $stages, 'nomFormation' => $nomFormation]);
    }

    public function ajoutEntreprise(Request $request, ObjectManager $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($request);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){

            //Enregistrer la ressource en BD
            $manager->persist($entreprise);
            $manager->flush();

            //Ramener l'user à la page d'accueil
            return $this->redirectToRoute('proStage_accueil');

        }

        return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView(), 'action' => "ajouter"]);
    }

    public function modifEntreprise(Request $request, ObjectManager $manager, Entreprise $entreprise)
    {

        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($request);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){

            //Enregistrer la ressource en BD
            $manager->persist($entreprise);
            $manager->flush();

            //Ramener l'user à la page d'accueil
            return $this->redirectToRoute('proStage_accueil');

        }

        return $this->render('pro_stage/ajoutModifEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView(), 'action' => "modifier"]);
    }


}
