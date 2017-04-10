<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use FOS\UserBundle\Util\LegacyFormHelper;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder->add('name', TextType::class, array('label'=>'Nom', 
                                                     'attr'=>array('class'=>'form-control')))
            ->add('firstname', TextType::class, array('label'=>'Prénom',
                                                      'attr'=>array('class'=>'form-control')))
            ->add('adress', TextType::class, array('label'=>'Adresse',
                                                   'attr'=>array('class'=>'form-control')))
            ->add('postcode', TextType::class, array('label'=>'Code postal',
                                                     'attr'=>array('class'=>'form-control')))
            ->add('city', TextType::class, array('label'=>'Ville',
                                                 'attr'=>array('class'=>'form-control')))
            ->add('phoneNumber', TextType::class, array('label'=>'Téléphone',
                                                        'attr'=>array('class'=>'form-control')))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), 
                    array('label' => 'Mail', 
                          'translation_domain' => 'FOSUserBundle',
                          'attr'=>array('class'=>'form-control')))
            ->add('Valider', SubmitType::class, array('attr' => array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }
}
