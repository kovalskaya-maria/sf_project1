<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Item;
use App\Entity\Reception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'name',
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name',
            ])
            ->add('amount')
            ->add('save', SubmitType::class, [
                'attr' => [

                ]
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reception::class,
        ]);
    }
}
