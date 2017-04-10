<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EstimateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDeparture', DateType::class,  array('label'=>'Date de départ',
                                                           'required'=>false,
                                                           'widget'=>'single_text',
                                                           'html5'=>false,
                                                           'attr'=>array('class'=>'js-datepicker')))
            ->add('nbrAdults', IntegerType::class,   array('label'=>'Nombre d\'adultes *',
                                                           'attr' => array('class'=>'form-control',
                                                            'min'=>0)))
            ->add('nbrChildren', IntegerType::class, array('label'=>'Nombre d\'enfants *',
                                                           'attr' => array('class'=>'form-control',
                                                            'min'=>0)))
            ->add('nbrDays', IntegerType::class,  array('label'=>'Nombre de jours *',
                                                        'attr' => array('class'=>'form-control',
                                                        'min'  =>0)))
            ->add('comment', TextareaType::class, array('label'=>'Décrivez précisément votre voyage *',
                                                        'attr'=>array('placeholder'=>'Régions, Thématiques, envies ...',
                                                                      'class'=>'form-control',
                                                                      'rows' => 8)))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-warning btn-lg')));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Estimate'
        ));
    }
}
