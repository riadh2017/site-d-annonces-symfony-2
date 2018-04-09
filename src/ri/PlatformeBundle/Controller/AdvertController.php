<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace ri\PlatformeBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ri\PlatformeBundle\Entity\Advert;
use ri\PlatformeBundle\Entity\Image;
use ri\PlatformeBundle\Entity\Application;
use ri\PlatformeBundle\Entity\AdvertSkill;


class AdvertController extends Controller
{

public function indexAction($page)
  {
        $nbPerPage = 3;

     $em = $this->getDoctrine()->getManager();
       $repository=$em->getRepository('riPlatformeBundle:Advert');

       $listAdverts=$repository->getAdvertWithApplications( $page,$nbPerPage);
           $nbPages = ceil(count($listAdverts)/$nbPerPage);




    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('riPlatformeBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'=>$nbPages,
      'page'=>$page,
    ));
  }



  public function viewAction($id)
  {
    

   
  
       $em = $this->getDoctrine()->getManager();
       $repository=$em->getRepository('riPlatformeBundle:Advert');

       $listApplication=$repository->getAdvertWithApplication($id);
       //$listecategory=$repository->getAdvertWithcategory(array('Graphisme','Intégration'));

        //$listAdvertSkills = $em->getRepository('riPlatformeBundle:AdvertSkill')->getAdvertWithSkill($id);

 
     //Le render ne change pas, on passait avant un tableau, maintenant un objet
    return $this->render('riPlatformeBundle:Advert:view.html.twig', array(
   
       //'listecategory'=>$listecategory,
      'listApplication'=>$listApplication
      //'listAdvertSkills'=>$listAdvertSkills
    ));
  
  }


   
  public function addAction(Request $request)
  {
    // Création de l'entité Advert
    $advert = new Advert();
    $advert->setTitle('Recherche développeur Symfony2.');
    $advert->setAuthor('Alexandre');
    $advert->setContent("Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…");

    // Création de l'entité Image
    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    // On lie l'image à l'annonce
    $advert->setImage($image);

   // creation de l'entite application
    $app1 = new Application();
    $app2 = new Application();

    $app1->setAuthor('riadh');
    $app1->setContent('je pose ma candidature');

    $app2->setAuthor('ali');
    $app2->setContent('je pose ma 1er candidature');

    $app1->setAdvert($advert);
    $app2->setAdvert($advert);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // recuperation des l'entites categorys
     $listecategory=$em->getRepository('riPlatformeBundle:Category')->findAll();

    foreach ($listecategory as $cat) {
      $advert->addCategory($cat);
    }

   // recuperation des l'entites skill
     $listeSkill=$em->getRepository('riPlatformeBundle:Skill')->findAll();

     foreach ($listeSkill as $skill) {
     $advertSkill = new AdvertSkill();

     $advertSkill->setAdvert($advert);
     $advertSkill->setSkill($skill);
     $advertSkill->setLevel('expert');

      $em->persist($advertSkill);
    }

    // Étape 1 : On « persiste » l'entité
    $em->persist($advert);
    $em->persist($app1);
    $em->persist($app2);



    // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
    // on devrait persister à la main l'entité $image
    // $em->persist($image);

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();


 // Si on n'est pas en POST, alors on affiche le formulaire  
   // return $this->render('riPlatformeBundle:Advert:add.html.twig');
    return $this->render('riPlatformeBundle:Advert:add.html.twig', array('advert' => $advert,'liste'=>$listeSkill ));
  }
    





  public function editAction($id, Request $request)
  {

    
    $advert = array(
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );

    return $this->render('riPlatformeBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  
    // Ici, on récupérera l'annonce correspondante à $id

  //   // Même mécanisme que pour l'ajout
  //   if ($request->isMethod('POST')) {
  //     $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

  //     return $this->redirectToRoute('ri_platform_view', array('id' => 5));
  //   }

  //   return $this->render('riPlatformeBundle:Advert:edit.html.twig');
  // }

  // public function deleteAction($id)
  // {
  //   // Ici, on récupérera l'annonce correspondant à $id

  //   // Ici, on gérera la suppression de l'annonce en question

  //   return $this->render('riPlatformeBundle:Advert:delete.html.twig');
  }


public function menuAction()
  {
    $limit=4;
      $em = $this->getDoctrine()->getManager();
       $repository=$em->getRepository('riPlatformeBundle:Advert');

       $listAdverts=$repository->getAdvertsMenu($limit);

    return $this->render('riPlatformeBundle:Advert:menu.html.twig', array(
    
      'listAdverts' => $listAdverts
    ));
  }

}
