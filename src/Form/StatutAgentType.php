<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\StatutAgent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('echellon', ChoiceType::class, [
                'choices' => [
                    '1er E' => '1er echellon',
                    '2ème E' => '2ème echellon',
                    '3ème E' => '3ème echellon',
                    '4ème E' => '4ème echellon',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('grade', ChoiceType::class, [
                'choices' => [
                    '1er C' => '1er classe',
                    '2ème C' => '2ème classe',
                    '3ème C' => '3ème classe',
                    '4ème C' => '4ème classe',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('hierarchie', ChoiceType::class, [
                'choices' => [
                    'A1' => 'A1',
                    'A2' => 'A2',
                    'A3' => 'A3',
                    'B1' => 'B1',
                    'B2' => 'B2',
                    'B3' => 'B3',
                    'B4' => 'B4',
                    'C1' => 'C1',
                    'C2' => 'C2',
                    'C3' => 'C3',
                    'D1' => 'D1',
                    'D2' => 'D2',
                    'D3' => 'D3',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_prise_service', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date Prise de Service',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('date_debut_ministere', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date début Ministère',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('date_avancement', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date dernier Avancement',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('agent', EntityType::class, [
                'class' => Agent::class,
                'choice_label' => function (Agent $agent) {
                    if($agent->getStatutAgents()->toArray()==null){
                        return $agent->getPrenom() . ' ' . $agent->getNom();
                    }
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatutAgent::class,
        ]);
    }
}
