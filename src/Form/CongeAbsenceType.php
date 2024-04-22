<?php

namespace App\Form;

use App\Entity\CongeAbsence;
use App\Entity\StatutAgent;
use App\Entity\TypeAbsence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CongeAbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('statut_agent', EntityType::class, [
                'class' => StatutAgent::class,
                'choice_label' => function ($statutAgent) {
                    return $statutAgent->getAgent()->getPrenom() . ' ' . $statutAgent->getAgent()->getNom() . '-' . $statutAgent->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('type_absence', EntityType::class, [
                'class'=> TypeAbsence::class,
                'choice_label'=>function ($typeAbsence) {
                    return $typeAbsence->getNomTypeAbsence();
                }
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de début",
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de fin",
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('Statut', ChoiceType::class, [
                'choices'=>[
                    'En Attente'=>'En Attente',
                    'En Cours'=>'En Cours',
                    'Suspendu'=>'Suspendu',
                    'Céssé'=>'Céssé',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('fichier', FileType::class, [
                'label' =>false,

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Charger un document PDF',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CongeAbsence::class,
        ]);
    }
}
