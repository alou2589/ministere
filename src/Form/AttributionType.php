<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Attribution;
use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('agent', EntityType::class, [
                'class' => Agent::class,
                'choice_label' => function ($agent) {
                    return $agent->getPrenom() . ' ' . $agent->getNom() . '-' . $agent->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('matos', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => function ($materiel) {
                    if($materiel->getAttributions()->toArray()==null){
                        return $materiel->getTypematos()->getNomTypeMatos() .' '. $materiel->getMarqueMatos()->getNomMarquematos() .' '. $materiel->getModeleMatos().'-'.$materiel->getSnMatos();
                    }
                },
                'attr' => ['class' => 'js-example-basic-single']
            ])
            ->add('date_attribution', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date d\'attribution',
                'attr' => ['class' => 'js-datepicker'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attribution::class,
        ]);
    }
}
