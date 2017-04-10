<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationAdminType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->id = $options['id'];

        $builder            
                
            ->add('commentAdmin', TextareaType::class, array('label'=>'Commentaire',
                                                        'required'=>false,
                                                        'attr' =>array('class'=>'form-control')))             
            ->add('save', SubmitType::class, array('label'=>'Mettre à jour',
                                                   'attr' =>array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Reservation',
            'id'         => null
        ));
    }
}
