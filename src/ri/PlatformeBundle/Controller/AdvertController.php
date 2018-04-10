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
use ri\PlatformeBundle\Form\AdvertType;




class AdvertController extends Controller
{

public function indexAction($page)
  {
        $nbPerPage = 3;

     $listAdverts = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('riPlatformeBundle:Advert')
     ->getAdvertWithApplications( $page,$nbPerPage)

     ;

      $nbPages = ceil(count($listAdverts)/$nbPerPage);

    return $this->render('riPlatformeBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
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
   
    // On crée un objet Advert
    $advert = new Advert();
    $advert->setDate(new \Datetime());
    $form=$this->createForm(AdvertType::class,$advert);

  $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->persist($advert->getImage());
        $em->flush();

        return $this->redirectToRoute('ri_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('riPlatformeBundle:Advert:add.html.twig' , array(
      'form' => $form->createView(),
    ));
  }
  
    





  public function editAction($id, Request $request)
  {

     $em = $this->getDoctrine()->getManager();
     $advert =$em->getRepository("riPlatformeBundle:Advert")->find($id);
    $form=$this->createForm(AdvertType::class,$advert);

    return $this->render('riPlatformeBundle:Advert:edit.html.twig', array(
      'form' => $form->createView(),
      'advert'=>$advert
    ));
  
   
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
