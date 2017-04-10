<?php

namespace UserBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
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
				->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'Mail', 
																														'translation_domain' => 'FOSUserBundle',
																														'attr'=>array('class'=>'form-control')))
           		->add('username', null, array('label' => 'Nom d\'utilisateur', 'translation_domain' => 'FOSUserBundle', 'attr'=>array('class'=>'form-control')))
           		->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe','attr'=>array('class'=>'form-control')),
                'second_options' => array('label' => 'Confirmez le mot de passe','attr'=>array('class'=>'form-control')),
                'invalid_message' => 'Ces mots de passe ne correspondent pas !'));
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';
	}

	public function getBlockPrefix()
	{
		return 'user_registration';
	}
}