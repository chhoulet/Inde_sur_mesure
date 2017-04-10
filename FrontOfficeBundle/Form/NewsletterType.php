<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,     array('label'=>'Titre*',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('underTitle', TextType::class,array('label'=>'Sous-titre*',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('text1', TextareaType::class, array('label'=> 'Entrez le texte N° 1 *',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('text2', TextareaType::class, array('label'=> 'Entrez le texte N° 2',
                                                      'attr'=>array('class'=>'form-control'),
                                                      'required'=>false))
            ->add('text3', TextareaType::class, array('label'=> 'Entrez le texte N° 3',
                                                      'attr'=>array('class'=>'form-control'),
                                                      'required'=>false))
            ->add('image',CollectionType::class,array('label'=> 'Ajoutez des images',
                                                      'entry_type'=> ImageType::class,                                                      
                                                      'attr'=>array('class'=>'form-control'),
                                                      'required'=>false))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success')))            
        ;
    }
    
    /**DateTime
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Newsletter'
        ));
    }
}
