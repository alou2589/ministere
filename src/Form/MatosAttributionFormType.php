<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Attribution;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatosAttributionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function ($affectation) {
                    return $affectation->getStatutAgent()->getAgent()->getPrenom() . ' ' . $affectation->getStatutAgent()->getAgent()->getNom() . '-' . $affectation->getStatutAgent()->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
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
