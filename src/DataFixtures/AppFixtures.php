<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\User;
use Doctrine\Migrations\Version\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Création de 2 utilisateurs de test
        $kiratof = new User();
        $kiratof->setPrenom('Christopher');
        $kiratof->setNom('Grassi');
        $kiratof->setEmail('c.grassi@hotmail.fr');
        $kiratof->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $kiratof->setPassword('$2y$10$2LUwzsMBem9hK71jpBwDX.NnUpv.l4CKmxPXZrD2zh2VTYn.F6UWG');
        $manager->persist($kiratof);

        $yrax = new User();
        $yrax->setPrenom('Bastien');
        $yrax->setNom('Serena');
        $yrax->setEmail('basty34@hotmail.fr');
        $yrax->setRoles(['ROLE_USER']);
        $yrax->setPassword('$2y$10$9nvwLIXOaizq2KWrZyos3.0J8XbCLDik9xtBELQy98FFr.kLNQ40K');
        $manager->persist($yrax);
        


        // Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR'); 

        // Création d'entreprises
        
        $nbEntreprises=30;
        
        for($i=1; $i<= $nbEntreprises; $i++)
        {
            $nomEntr=$faker->company;
            $entreprise = new Entreprise();
            $entreprise->setNom($nomEntr);
            $entreprise->setActivite($faker->realText($maxNbChars = 20, $indexSize = 2));
            $entreprise->setAdresse($faker->streetAddress);
            $entreprise->setSiteWeb("www.$nomEntr.com");

            $tableauEntreprises[$i]=$entreprise;
          
        }

        foreach($tableauEntreprises as $entreprise)
        {
         $manager->persist($entreprise);
        }
        
        // Création des formations
        
        $DUTInfo = new Formation();
        $DUTInfo->setNom("Diplôme Univ Techno Info");
        $DUTInfo->setIntitule("DUT Info");
        $DUTInfo->setDiscipline("Informatique");

        $LicenceP = new Formation();
        $LicenceP->setNom("Licence Pro Multimédia");
        $LicenceP->setIntitule("LP Multimédia");
        $LicenceP->setDiscipline("Informatique");

        $DUTic = new Formation();
        $DUTic->setNom("Diplôme de l'Info et de la Com");
        $DUTic->setIntitule("DU TIC");
        $DUTic->setDiscipline("Communication");

        // On regroupe les objets "Formation" dans un tableau
       
        $tableauFormations = array($DUTInfo,$LicenceP,$DUTic);

         // Pour chaque formation
         foreach ($tableauFormations as $formation) {
            // Création des stages associés
            $nbStagesProposesFormation= $faker->numberBetween($min = 0, $max = 10);
            for($i=0; $i <= $nbStagesProposesFormation; $i++)
            {
                $stage=new Stage();
                $stage->setTitre($faker->realText($maxNbChars = 20, $indexSize = 2));
                $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
                $stage->setEmail($faker->companyEmail);
                $stage->setMissions($faker->realText($maxNbChars = 50, $indexSize = 2));
                $stage->setDateAjout($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = 'Europe/Paris'));
                $stage->addFormation($formation);
                

              
                // Sélectionner une Entreprise au hasard 
                $numEntreprise = $faker->numberBetween($min = 1, $max = 30);
                // Création relation Stage --> Entreprise
                $stage->setEntreprise($tableauEntreprises[$numEntreprise]);
                // Création relation Entreprise --> Stage
                $tableauEntreprises[$numEntreprise] -> addStage($stage);
                // Persister les objets modifiés
                $manager->persist($stage);
                $manager->persist($tableauEntreprises[$numEntreprise]);
            }

            $manager->persist($formation);
        }


    
        $manager->flush();
    }
}
