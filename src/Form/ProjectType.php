<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('members', EntityType::class, [
                'class' => Member::class,
                'choice_label' => function (Member $member) {
                    return $member->getFirstName() . ' ' . $member->getLastName();
                },
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer le projet',
                'attr' => [
                    'class' => 'button button-submit',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
