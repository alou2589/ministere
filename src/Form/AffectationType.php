<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Agent;
use App\Entity\Poste;
use App\Entity\SousStructure;
use App\Entity\StatutAgent;
use App\Repository\StatutAgentRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut_agent', EntityType::class, [
                'class' => StatutAgent::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('s')
                        ->select('s','a')
                        ->leftJoin('s.agent','a');
                },
                'choice_label' => function ($statutAgent) {
                    return $statutAgent->getAgent()->getPrenom() . ' ' . $statutAgent->getAgent()->getNom() . '-' . $statutAgent->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('sous_structure', EntityType::class, [
                'class'=>SousStructure::class,
                'label' => "Service / Cellule /Bureau",
                'choice_label'=>'nom_sous_structure',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('poste', EntityType::class, [
                'class'=>Poste::class,
                'choice_label'=>'nom_poste',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_affectation', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date d'affectation",
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('status_affectation', ChoiceType::class, [
                'choices'=>[
                    'En Attente'=>'en attente',
                    'En Service'=>'en service',
                    'Affecté(e)'=>'affecté',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
