<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\StatutAgent;
use App\Entity\TypeFichier;
use App\Entity\FichiersAgent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FichiersAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_fichier', EntityType::class, [
                'class' => TypeFichier::class,
                'choice_label' => function (TypeFichier $type_fichier) {
                    return $type_fichier->getNomTypeFichier();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('statut_agent', EntityType::class, [
                'class' => StatutAgent::class,
                'choice_label' => function (StatutAgent $statutAgent) {
                    return $statutAgent->getAgent()->getPrenom().' '.$statutAgent->getAgent()->getNom().' '.$statutAgent->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('nom_fichier')
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
            'data_class' => FichiersAgent::class,
        ]);
    }
}
