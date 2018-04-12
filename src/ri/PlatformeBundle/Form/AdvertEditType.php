<?php

namespace ri\PlatformeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;





class AdvertEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder
      ->remove('date') ;
    }
     

    /**
     * {@inheritdoc}
     */
    
   /* public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ri\PlatformeBundle\Entity\Advert'
        ));
    }

    public function getName()
    {
        return 'ri_platformebundle_advert_edit';
    }
*/
  public function getParent()
  {

    return AdvertType::class;
  }


}
