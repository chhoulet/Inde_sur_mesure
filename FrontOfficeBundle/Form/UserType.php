<?php

namespace FrontOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('entity', EntityType::class, array('label'=>'Choisissez la ou les personne(s) :',
												     'multiple'=>true,
												     'class'=>'UserBundle:User',
												     'choice_label'=>'FullName',
												     'attr'=>array('class'=>'form-control')))
			->add('valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success btn-lg')))
			->add('adminRights', SubmitType::class, array('label'=>'Retrait des droits d\'administrateur',
														  'attr'=>array('class'=>'btn btn-info btn-lg')));
	}
} 