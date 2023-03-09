<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\MarqueMatos;
use App\Entity\Materiel;
use App\Entity\TypeMateriel;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_matos', EntityType::class, [
                'class'=>TypeMateriel::class,
                'choice_label'=>'nom_type_matos',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('marque_matos', EntityType::class, [
                'class'=>MarqueMatos::class,
                'choice_label'=>'nom_marque_matos',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('modele_matos')
            ->add('sn_matos')
            ->add('date_reception', DateType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('fournisseur', EntityType::class, [
                'class'=>Fournisseur::class,
                'choice_label'=>'nom_fournisseur',
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('info_matos', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
