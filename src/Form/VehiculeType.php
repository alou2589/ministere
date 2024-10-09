<?php

namespace App\Form;

use App\Entity\MarqueVehicule;
use App\Entity\TypeVehicule;
use App\Entity\Vehicule;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_vehicule', EntityType::class, [
                'class' => TypeVehicule::class,
                'choice_label' => 'nom_type_vehicule',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('marque_vehicule', EntityType::class, [
                'class' => MarqueVehicule::class,
                'choice_label' => 'nom_marque_vehicule',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('modele_vehicule')
            ->add('immatriculation')
            ->add('date_enregistrement', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('date_circulation', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('info_vehicule', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
