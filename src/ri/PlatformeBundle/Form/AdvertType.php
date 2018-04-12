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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;




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
      ->add('image', ImageType::class )
      ->add('categories', EntityType::class, array(
               'class'        => Category::class,
               'choice_label' => 'name',
               'multiple'     => false))

      // pour permettre de saisir des category
     /* ->add('categories',CollectionType::class,array('entry_type'=>  CategoryType::class, 'allow_add'=>true,'allow_delete'=>true,'prototype' => true,'by_reference' => false ))*/
            
    
      ->add('save',SubmitType::class)
      //->setAction("home/test")
    ;



     // On ajoute une fonction qui va écouter un évènement
    $builder
    ->addEventListener(
      FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
      function(FormEvent $event) { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
        // On récupère notre objet Advert sous-jacent
        $advert = $event->getData();

        // Cette condition est importante, on en reparle plus loin
        if (null === $advert) {
          return; // On sort de la fonction sans rien faire lorsque $advert vaut null
        }

        if (!$advert->getPublished() || null == $advert->getId()) {
          // Si l'annonce n'est pas publiée, ou si elle n'existe pas encore en base (id est null),
          // alors on ajoute le champ published
          $event->getForm()->add('published', CheckboxType::class, array('required' => false));
        } else {
          // Sinon, on le supprime
          $event->getForm()->remove('published');
        }
    }
     );
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
