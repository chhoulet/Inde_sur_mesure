<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, array('label'=>'Email *',
                                                  'attr' =>array('class'=>'form-control',
                                                  'placeholder'=>'example@gmail.com')))
            ->add('save', SubmitType::class, array('label'=>'S\'inscrire',
                                                   'attr' =>array('class'=>'btn btn-success')))
            ->add('goback', SubmitType::class, array('label'=>'Se désinscrire',
                                                     'attr' =>array('class'=>'btn btn-danger')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Mail'
        ));
    }
}
