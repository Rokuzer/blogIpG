<?php

// src/Form/Type/BlogType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Form\Type\ShippingType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title',TextType::class, ['required' => true]);
        $builder->add('body',TextType::class, ['required' => true]);
        $builder->add('autor',TextType::class, ['required' => true]);
        $builder->add('Create',SubmitType::class);
    }
}