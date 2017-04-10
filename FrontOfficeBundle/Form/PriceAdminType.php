<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PriceAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', TextType::class, array('label'=>'Catégorie *',
                                                     'attr'=>array('class'=>'form-control',
                                                                   'placeholder'=>'Chambre simple, Chambre supérieure de luxe, Suite junior')
                                                    ))
            ->add('single', IntegerType::class, array('label'=>'Personne seule *',
                                                     'attr'=>array('class'=>'form-control',
                                                     'min' =>0,
                                                     'placeholder'=>'Veuillez saisir uniquement des chiffres !')))
            ->add('couple', IntegerType::class, array('label'=>'Chambre double *',
                                                     'attr'=>array('class'=>'form-control',
                                                     'min' =>0,
                                                     'placeholder'=>'Veuillez saisir uniquement des chiffres !')))           
            ->add('Valider', SubmitType::class, array('label'=>'Valider',
                                                        'attr'=>array('class'=>'btn btn-warning')))
            ->add('Save_and_add', SubmitType::class, array('label'=>'Valider et ajouter une autre catégorie',
                                                        'attr'=>array('class'=>'btn btn-warning')))
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
