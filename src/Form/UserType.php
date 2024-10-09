<?php

namespace App\Form;

use App\Entity\Affectation;
use App\Entity\StatutAgent;
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
            ->add('affectation', EntityType::class, [
                'class' => Affectation::class,
                'choice_label' => function (Affectation $affectation) {
                    return $affectation->getStatutAgent()->getAgent()->getPrenom().' '.$affectation->getStatutAgent()->getAgent()->getNom().' '.$affectation->getStatutAgent()->getMatricule();
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
                    'Parc Auto Admin' => 'ROLE_PARC_AUTO_ADMIN',
                    'Technicien' => 'ROLE_TECH',
                    'Utilisateur' => 'ROLE_USER',
                    'Utilisateur RH' => 'ROLE_RH_USER',
                    'Utilisateur Info' => 'ROLE_INFO_USER',
                    'Utilisateur Gestion' => 'ROLE_Gestion_USER',
                    'Utilisateur Parc Auto' => 'ROLE_Gestion_USER',
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
