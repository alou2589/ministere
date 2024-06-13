<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Agent;
use App\Entity\CartePro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CarteProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function (Affectation $affectation) {
                        return $affectation->getStatutAgent()->getAgent()->getPrenom().' '.$affectation->getStatutAgent()->getAgent()->getNom().' '.$affectation->getStatutAgent()->getMatricule();
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('date_delivrance', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date de Délivrance',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('date_expiration', DateType::class, [ 
                'widget' => 'single_text',
                'label' => 'Date d\'expiration',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('photo_agent', FileType::class, [
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
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Charger une image',
                    ])
                ],
            ])
            ->add('status_impression', CheckboxType::class, [
                'label'=>false,
            ])
        ;
        $builder->get('status_impression')
            ->addModelTransformer(new CallbackTransformer(
                function ($activeAsString) {
                    // transform the string to boolean
                    return (bool)(int)$activeAsString;
                },
                function ($activeAsBoolean) {
                    // transform the boolean to string
                     return (string)(int)$activeAsBoolean;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartePro::class,
        ]);
    }
}
