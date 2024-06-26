<?php

namespace App\Form\Type;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            TextType::class,
            [
                'label' => 'Email',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'nick',
            TextType::class,
            [
                'label' => 'Nick',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'content',
            TextType::class,
            [
                'label' => 'Content',
                'required' => true,
                'attr' => ['max_length' => 1000],
            ]
        );
        $builder->add(
            'post',
            EntityType::class,
            [
                'class' => Post::class,
                'choice_label' => 'title',
                'label' => 'Post',
                'required' => true,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Comment::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'comment';
    }
}
