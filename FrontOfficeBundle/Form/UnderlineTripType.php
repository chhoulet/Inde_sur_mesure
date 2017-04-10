<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UnderlineTripType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('undertitle', TextType::class,     array('label'=>'Titre',
                                                            'required'=>false,
                                                           'attr'=>array('placeholder'=>'Jour 1 & 2',
                                                                         'class'=>'form-control')))
            ->add('main', TextareaType::class,       array('label'=>'Description',
                                                           'required'=>false,
                                                           'attr'=>array('placeholder'=>'Arrivée à Bombay, visite de temple ...',
                                                                         'class'=>'form-control')))
            ->add('photo', FileType::class,          array('label' => 'Photo',                                                           
                                                           'required'=>false))
            ->add('save', SubmitType::class,         array('label' => 'Valider',
                                                           'attr'=>array('class'=>"btn btn-warning")))
            ->add('saveAndAdd', SubmitType::class,   array('label' => 'Valider et ajouter une autre description',
                                                           'attr'=>array('class'=>"btn btn-warning")))
            ->add('saveAndPrice', SubmitType::class, array('label'=>'Valider et ajouter les prix',
                                                           'attr'=>array('class'=>"btn btn-warning")))         
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\UnderlineTrip'
        ));
    }
}
