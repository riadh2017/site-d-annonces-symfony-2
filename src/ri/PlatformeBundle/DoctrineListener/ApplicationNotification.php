<?php
// src/ri/PlatformeBundle/DoctrineListener/ApplicationNotification.php

namespace ri\PlatformeBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use ri\PlatformeBundle\Entity\Application;

class ApplicationNotification
{
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getEntity();

    // On veut envoyer un email que pour les entités Application
    if (!$entity instanceof Application) {
      return;
    }

    $message = new \Swift_Message(
      'Nouvelle candidature',
      'Vous avez reçu une nouvelle candidature.'
    );
    
    $message
      ->addTo($entity->getAdvert()->getAuthor()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->addFrom('riad.mi.2012@gmail.com')
    ;

    $this->mailer->send($message);
  }
}