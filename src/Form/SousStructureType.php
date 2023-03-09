<?php

namespace App\Form;

use App\Entity\SousStructure;
use App\Entity\Structure;
use App\Entity\TypeSousStructure;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousStructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_sous_structure')
            ->add('type_sous_structure', EntityType::class, [
                'class'=>TypeSousStructure::class,
                'choice_label'=>'nom_type_sous_structure',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('structure', EntityType::class, [
                'class'=>Structure::class,
                'choice_label'=>'nom_structure',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('description_sous_structure', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousStructure::class,
        ]);
    }
}
