<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TripType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' =>'Nom *',
                                                  'attr'=>array('class'=>'form-control')))
            ->add('period', TextType::class, array('label' =>'Saison *',
                                                   'required'=>false,
                                                   'attr'=>array('class'=>'form-control')))
            ->add('place', TextType::class, array('label' =>'Lieu',
                                                  'required'=>false,
                                                  'attr'=>array('class'=>'form-control',
                                                  'placeholder' => 'Région, ville ...')))
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
            ->add('description', TextareaType::class, array('label' =>'Description *',                                                           
                                                            'required'=>false,
                                                            'attr'=>array('class'=>'form-control',
                                                            'placeholder' => 'Détails du séjour...')))
            ->add('comment1', TextareaType::class, array('label'=>'Commentaire Photo N° 2',
                                                            'required'=>false,
                                                            'attr'=>array('class'=>'form-control',
                                                            'placeholder' => 'Commentaire libre...')))
            ->add('comment2', TextareaType::class, array('label'=>'Commentaire Photo N° 3',
                                                            'required'=>false,
                                                            'attr'=>array('class'=>'form-control',
                                                            'placeholder' => 'Commentaire libre...')))                                             
            ->add('numberDays', IntegerType::class, array('label'=>'Nombre de jours',
                                                          'required'=>false,
                                                          'attr'=>array('class'=>'form-control',
                                                                        'min'=>0)))            
            ->add('thematic', EntityType::class, array('label'=>'Sélectionnez un thème ',
                                                        'class' => 'FrontOfficeBundle:Thematic',
                                                        'choice_label' => 'name',
                                                        'required' =>false,
                                                        'attr'=>array('class'=>'form-control')))                                                         
            ->add('image', CollectionType::class, array('label' =>'Ajoutez des images',
                                                        'entry_type'=>ImageType::class,
                                                        'allow_add'=>true,
                                                        'data_class' => null,
                                                        'allow_delete'=>true))
            ->add('brochure', FileType::class, array('label'=>'Ajouter une brochure au format PDF',
                                                     'data_class' => null,
                                                     'required'=>false))                  
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-warning')))
            ->add('Save_and_add', SubmitType::class, 
                   array('label'=>'Valider et ajouter une description journalière',
                         'attr'=>array('class'=>'btn btn-warning')))           
        ;
    }
   
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOfficeBundle\Entity\Trip'
        ));
    }
}
