<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Technicien;
use App\Entity\Ticket;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matos', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => function ($materiel) {
                    if ($materiel->getTickets()->toArray()==null) {
                        return $materiel->getTypeMatos()->getnomTypeMatos() . ' ' . $materiel->getMarqueMatos()->getNomMarqueMatos() . ' ' . $materiel->getModeleMatos();
                    }
                }
            ])
            ->add('technicien', EntityType::class, [
                'class' => Technicien::class,
                'label'=>'Affecté au technicien',
                'choice_label' => function ($technicien) {
                    return $technicien->getAgent()->getPrenom() . ' ' . $technicien->getAgent()->getNom().' '.$technicien->getAgent()->getMatricule();
                }
            ])
            ->add('description_proprietaire', CKEditorType::class)
            ->add('date_declaration', DateTimeType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('observation_technicien', CKEditorType::class)
            ->add('solution_apportée', CKEditorType::class)
            ->add('date_sortie', DateTimeType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('type_urgence', ChoiceType::class, [
                'choices'=>[
                    'En Panne'=>'En Panne',
                    'Réparé'=>'Réparé',
                    'Amorti'=>'Amorti',
                ]
            ])
            ->add('status_ticket', ChoiceType::class, [
                'choices' => [
                    'Valider' => 'Valider',
                    'En Cours' => 'En Cours',
                    'Clôturer' => 'Clôturer',
                ],
                'attr'=>['class'=>'js-example-basic-single']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
