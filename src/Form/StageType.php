<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('missions', TextareaType::class)
            ->add('email', EmailType::class)
            ->add('entreprise', EntrepriseType::class)
            ->add('entreprise', EntityType::class, array(

                'class' => Entreprise::class,
                'query_builder' => function (EntrepriseRepository $repEntreprise) {
                    return $repEntreprise->createQuerybuilder('e')
                    ->orderBy('e.nom', 'ASC');
                },
                'choice_label' => function(Entreprise $entreprise){
                    return $entreprise->getNom();
                },
                
                'multiple' => false,
                'expanded' => false,


            ))
            ->add('formations', EntityType::class, array(

                'class' => Formation::class,
                'query_builder' => function (FormationRepository $repFormation) {
                    return $repFormation->createQuerybuilder('f')
                    ->orderBy('f.intitule', 'ASC');
                },
                'choice_label' => function(Formation $formation){
                    return $formation->getIntitule() . ' - ' . $formation->getDiscipline();
                },
                
                'multiple' => true,
                'expanded' => true,


            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
