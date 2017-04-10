<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class)
            ->add('email', TextType::class)
            ->add('subject', ChoiceType::class, array('choices'=>array('Tarifs'=>0,
                                                                       'Visa'=>1,
                                                                       'Santé, Vaccination'=>2,
                                                                       'Informations générales sur l\'Inde'=>3,
                                                                       'Dates de séjour'=>4,
                                                                       'Autre domaine'=>5)))
            ->add('main', TextareaType::class)            
            ->add('Envoyer', SubmitType::class, array('attr'=>array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Message'
        ));
    }
}
