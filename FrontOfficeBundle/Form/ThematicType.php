<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ThematicType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('name', TextType::class,      array('label'=>'Titre *',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('underline', TextType::class, array('label'=>'Sous-titre principal',
                                                      'required'=>false,
                                                      'attr'=>array('class'=>'form-control')))
            ->add('underline1', TextType::class, array('label'=>'Sous-titre secondaire',
                                                      'required'=>false,
                                                      'attr'=>array('class'=>'form-control')))
            ->add('main1', TextareaType::class, array('label'=>'Description N° 1 *',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('underline2', TextType::class, array('label'=>'Sous-titre tertiaire',
                                                      'required'=>false,
                                                      'attr'=>array('class'=>'form-control')))
            ->add('main2', TextareaType::class, array('label'=>'Description secondaire',
                                                      'required'=>false,
                                                      'attr'=>array('class'=>'form-control')))
            ->add('image', CollectionType::class, array('entry_type'  => ImageType::class,
                                                        'allow_add'   =>true,
                                                        'allow_delete'=>true))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-warning')))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Thematic'
        ));
    }
}
