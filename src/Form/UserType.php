<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('agent', EntityType::class, [
                'class' => Agent::class,
                'choice_label' => function (Agent $agent) {
                    if ($agent->getUsers()->toArray()==null) {
                        return $agent->getPrenom().' '.$agent->getNom().' '.$agent->getMatricule();
                    }
                },
                'attr'=>['class'=>'js-example-basic-single']
            ])
            ->add('username')
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'multiple'=>true,
                'choices' => [
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                    'Admin' => 'ROLE_ADMIN',
                    'RH Admin' => 'ROLE_RH_ADMIN',
                    'Info Admin' => 'ROLE_INFO_ADMIN',
                    'Gestion Admin' => 'ROLE_GESTION_ADMIN',
                    'Technicien' => 'ROLE_TECH',
                    'Utilisateur' => 'ROLE_USER',
                    'Utilisateur RH' => 'ROLE_RH_USER',
                    'Utilisateur Info' => 'ROLE_INFO_USER',
                    'Utilisateur Gestion' => 'ROLE_Gestion_USER',
                ],
                'attr'=>['class'=>'js-example-basic-multiple']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
