<?php
/**
 * Created by PhpStorm.
 * User: quentinrillet
 * Date: 02/12/2016
 * Time: 19:39
 */

namespace Api\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('login')
      ->add('password');
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => 'Api\UserBundle\Entity\Credentials',
      'csrf_protection' => false
    ]);
  }
}