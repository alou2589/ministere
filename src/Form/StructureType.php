<?php

namespace App\Form;

use App\Entity\Structure;
use App\Entity\TypeStructure;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('type_structure', EntityType::class, [
                'class'=>TypeStructure::class,
                'choice_label'=>'nom_type_structure',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('nom_structure')
            ->add('description_structure', CKEditorType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
