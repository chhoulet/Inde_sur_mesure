<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', TextType::class, array('disabled'=>true))                                                    
            ->add('single', IntegerType::class, array('disabled'=>true))
            ->add('couple', IntegerType::class, array('disabled'=>true))
            ->add('numberRoomsSingle', IntegerType::class, array('attr'=>array('placeholder'=>'0,1,2,3 ...',
                                                                         'min' => 0),
                                                                         'required' => false))
            ->add('numberRoomsCouple', IntegerType::class, array('attr'=>array('placeholder'=>'0,1,2,3 ...',
                                                                 'min' => 0),
                                                                 'required' => false))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Price'
        ));
    }
}
