<?php

namespace App\Form;

use App\Entity\CategorieMateriel;
use App\Entity\TypeMateriel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeMaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_type_matos')
            ->add('categorie_matos', EntityType::class, [
                'class'=>CategorieMateriel::class,
                'choice_label'=>'nom_categorie_matos',
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeMateriel::class,
        ]);
    }
}
