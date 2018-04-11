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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ri\PlatformeBundle\Entity\Advert;
use ri\PlatformeBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;




class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder
      ->add('date'   ,DateType::class,['label'=>'date'])
      ->add('title' ,TextType::class )
      ->add('content'  ,TextareaType::class )
      ->add('author' , TextType::class)
      ->add('published' ,CheckboxType::class)
      ->add('image', ImageType::class )
      ->add('categories', EntityType::class, array(
  'class'    => Category::class,
  'choice_label'=> 'name',
  'multiple' => false))


      // pour permettre de saisir des category
      /*->add('categories',CollectionType::class,array('entry_type'=>  CategoryType::class, 'allow_add'=>true,'allow_delete'=>true  ))*/
            
    
      ->add('save',SubmitType::class)
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
