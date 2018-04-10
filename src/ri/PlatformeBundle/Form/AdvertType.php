<?php

namespace ri\PlatformeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ri\PlatformeBundle\Entity\Advert;




class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder
      ->add('date'   ,DateType::class,['label'=>'date creation'])
      ->add('title' ,TextType::class )
      ->add('content'  ,TextareaType::class )
      ->add('author' , TextType::class)
      ->add('published' ,CheckboxType::class)
      ->add('save',SubmitType::class )
      //->setAction("home/test")
    ;
    }
     

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ri\PlatformeBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ri_platformebundle_advert';
    }


}
