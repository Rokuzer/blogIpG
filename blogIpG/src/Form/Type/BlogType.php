<?php

// src/Form/Type/BlogType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Form\Type\ShippingType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('autor', ChoiceType::class, [
            'choices' => [
                'Leanne Graham' => 1,
                'Ervin Howell' => 2,
                'Clementine Bauch' => 3,
                'Patricia Lebsack' => 4,
                'Chelsey Dietrich' => 5,
                'Mrs. Dennis Schulist' => 6,
                'Kurtis Weissnat' => 7,
                'Nicholas Runolfsdottir V' => 8,
                'Glenna Reichert' => 9,
                'Clementina DuBuque' => 10,
            ],
        ]);
        $builder->add('title', TextType::class, ['required' => true]);
        $builder->add('body', TextareaType::class, ['required' => true]);
        $builder->add('Create', SubmitType::class);
    }
}