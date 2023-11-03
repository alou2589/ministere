<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Maintenance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MaintenanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_maintenance', DateType::class, [ 
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('status_matos', ChoiceType::class, [
                'choices' => [
                    'En Cours' => 'En Panne',
                    'Effectuer' => 'Effectuer',
                    'Amorti' => 'Amorti',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_sortie', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('matos', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => function ($materiel) {
                    if($materiel->getAttributions()->toArray()==null){
                        return $materiel->getSnMatos() .' '. $materiel->getMarqueMatos()->getNomMarquematos() .' '. $materiel->getModeleMatos();
                    }
                },
                'attr' => ['class' => 'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maintenance::class,
        ]);
    }
}
