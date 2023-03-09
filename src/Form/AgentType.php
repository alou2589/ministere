<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Poste;
use App\Entity\SousStructure;
use App\Entity\TypeAgent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('date_naissance', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('lieu_naissance')
            ->add('genre', ChoiceType::class, [
                'choices'=>[
                    'Homme'=>'homme',
                    'Femme'=>'femme',
                ]
            ])
            ->add('type_agent', EntityType::class, [
                'class'=>TypeAgent::class,
                'choice_label'=>'nom_type_agent',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('matricule')
            ->add('fonction')
            ->add('poste', EntityType::class, [
                'class'=>Poste::class,
                'choice_label'=>'nom_poste',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('sous_structure', EntityType::class, [
                'class'=>SousStructure::class,
                'choice_label'=>'nom_sous_structure',
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
