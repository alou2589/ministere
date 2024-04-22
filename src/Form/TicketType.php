<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Technicien;
use App\Entity\Ticket;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                    return $technicien->getInfoTechnicien()->getStatutAgent()->getAgent()->getPrenom() . ' ' . $technicien->getInfoTechnicien()->getStatutAgent()->getAgent()->getNom().' '.$technicien->getInfoTechnicien()->getStatutAgent()->getMatricule();
                }
            ])
            ->add('description_proprietaire', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('date_declaration', DateTimeType::class, [ 
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('type_urgence', ChoiceType::class, [
                'choices'=>[
                    'Trés Urgent'=>'Trés Urgent',
                    'Urgent'=>'Urgent',
                    'Normal'=>'Normal',
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
