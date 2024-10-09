<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\AffectationVehicule;
use App\Entity\EtatVehicule;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationVehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('a')
                        ->select('a','sta','ag')
                        ->leftJoin('a.statut_agent','sta')
                        ->leftJoin('sta.agent','ag');
                },
                'choice_label' => function ($affectation) {
                    return $affectation->getStatutAgent()->getAgent()->getPrenom() . ' ' . $affectation->getStatutAgent()->getAgent()->getNom() . '-' . $affectation->getStatutAgent()->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_affectation_vehicule', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date d'affectation du véhicule",
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => function ($vehicule) {
                    if($vehicule->getAffectationVehicules()->toArray()==null){
                        return $vehicule->getTypeVehicule()->getNomTypeVehicule() .' '. $vehicule->getMarqueVehicule()->getNomMarqueVehicule() .' '. $vehicule->getModeleVehicule().'-'.$vehicule->getImmatriculation();
                    }
                },
                'attr' => ['class' => 'js-example-basic-single']
            ])
            ->add('etat_vehicule', EntityType::class, [
                'class' => EtatVehicule::class,
                'choice_label' => 'nom_etat_vehicule',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffectationVehicule::class,
        ]);
    }
}
