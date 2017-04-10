<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename', FileType::class,  array('label'=>'Photo principale',
                                                      'data_class'=>null))
            ->add('filename1', FileType::class, array('label'=>'Photo secondaire',
                                                      'required'=>false,
                                                      'data_class'=>null))
            ->add('filename2', FileType::class, array('label'=>'Photo tertiaire',
                                                      'required'=>false,
                                                      'data_class'=>null))
            /*->add('thematic', EntityType::class, array('label'=>'Cette image est-elle rattachée à une thématique ?',
                                                       'class'=>'FrontOfficeBundle:Thematic',
                                                       'choice_label'=>'name',
                                                       'attr'=>array('class'=>'form-control')))
            ->add('trip', EntityType::class,    array('label'=>'Cette image est-elle rattachée à un voyage ?',
                                                       'class'=>'FrontOfficeBundle:Trip',
                                                       'choice_label'=>'title',
                                                       'attr'=>array('class'=>'form-control')))  */                     
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Image'
        ));
    }
}
