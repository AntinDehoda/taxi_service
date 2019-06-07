<?php


namespace App\Form;

use App\Entity\District;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DTO\OrderDto;


final class OrderEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phone', TextType::class)
            ->add('district', EntityType::class, [
                'class' => District::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
            ])
            ->add('streetFrom', TextType::class)
            ->add('streetFromNumber', TextType::class)
            ->add('streetTo', TextType::class)
            ->add('streetToNumber', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => OrderDto::class]);
    }
}