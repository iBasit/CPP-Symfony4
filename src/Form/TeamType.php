<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Name cannot be empty']),
                ],
            ])
            ->add('strip', TextType::class)
            ->add('league', EntityType::class, [
                'class' => League::class,
                'constraints' => [
                    new NotBlank(['message' => 'League cannot be empty']),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'team';
    }
}
