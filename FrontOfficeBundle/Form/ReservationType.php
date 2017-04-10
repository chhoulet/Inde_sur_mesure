<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FrontOfficeBundle\Entity\Price;
use FrontOfficeBundle\Repository\PriceRepository;

class ReservationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->id = $options['id'];

        $builder            
            ->add('price', CollectionType::class, array('entry_type' => PriceType::class))
            ->add('nbrAdults',  ChoiceType::class, array('label'=>'Nombre d\'adultes',
                                                          'required'=>false,
                                                          'choices' => array(0=>0,
                                                                           1=>1,
                                                                           2=>2,
                                                                           3=>3,
                                                                           4=>4,
                                                                           5=>5,
                                                                           'Plus'=>6),
                                                          'attr'=>array('placeholder' => 'Nombre d\'adultes'),
                                                          'empty_data'  => null,
                                                          'attr'=>array('class'=>'form-control',
                                                          'min' =>0 )))        
            ->add('nbrChildren',  ChoiceType::class, array('label'=>'Nombre d\'enfants',
                                                           'required'=>false,
                                                           'choices' => array(0=>0,
                                                                           1=>1,
                                                                           2=>2,
                                                                           3=>3,
                                                                           4=>4,
                                                                           5=>5,
                                                                           'Plus'=>6),
                                                           'attr'=>array('placeholder' => 'Nombre d\'enfants'),
                                                           'empty_data'  => null,
                                                           'attr'=>array('class'=>'form-control',
                                                           'min' =>0 )))    
            ->add('comment', TextareaType::class, array('label'=>'Commentaire',
                                                        'required'=>false,
                                                        'attr' =>array('class'=>'form-control',
                                                                       'placeholder'=>'Ce champ n\'est pas obligatoire')))
            ->add('accepted', CheckboxType::class, array('label'    => 'J\'ai lu les conditions générales de vente')) 
            ->add('save', SubmitType::class, array('label'=>'Réservez',
                                                   'attr' =>array('class'=>'btn btn-success btn-lg')))
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
