<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FrontOfficeBundle\Repository\TripRepository;

class TripChoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trip', EntityType::class, array('label' =>'Attribuer un voyage déjà existant :',
                                                   'class'=>'FrontOfficeBundle:Trip',
                                                   'choice_label'=>'title',
                                                   'multiple'=>false,
                                                   'query_builder'=>function(TripRepository $er)
                                                   {
                                                        return $er->getTripsPrivate();
                                                   },
                                                   'attr'=>array('class'=>'form-control')))            
            ->add('globalPrice', IntegerType::class, array('label'=>'Prix global forfaitaire',
                                                           'required'=>false,
                                                           'attr'=>array('class'=>'form-control',
                                                                         'min'=>0)))
            ->add('dateBegining', DateType::class, array('label'=>'Date de départ',
                                                         'required'=>false,
                                                         'widget' => 'single_text',
                                                         // do not render as type="date", to avoid HTML5 date pickers
                                                         'html5' => false,
                                                         // add a class that can be selected in JavaScript
                                                         'attr' => ['class' => 'js-datepicker']))
            ->add('dateEnding', DateType::class, array('label'=>'Date de retour',
                                                       'required'=>false,
                                                       'widget'=>'single_text',                                                      
                                                       'html5'=>false,
                                                       'attr'=> ['class' => 'js-datepicker']))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success')))                       
        ;
    }
      
}
