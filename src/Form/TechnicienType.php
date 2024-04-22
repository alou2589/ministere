<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Technicien;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('info_technicien', EntityType::class, [
                'class'=>User::class,
                'choice_label' => function($user){
                    if (in_array("ROLE_TECH", $user->getRoles()) && $user->getTechniciens()->toArray()==null) {
                        # code...
                        return $user->getAffectation()->getStatutAgent()->getAgent()->getPrenom() . ' ' . $user->getAffectation()->getStatutAgent()->getAgent()->getNom();
                    }
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technicien::class,
        ]);
    }
}
