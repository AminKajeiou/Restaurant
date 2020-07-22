<?php

namespace embi\RestauBundle\Controller;


use Doctrine\DBAL\Types\IntegerType;
use embi\RestauBundle\embiRestauBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use embi\RestauBundle\Entity\Plats;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use embi\RestauBundle\Entity\Commandes;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class RestauController extends Controller
{
    public function indexAction()
    {
        return $this->render('@embiRestau/Restau/index.html.twig');
    }

    public function platsAction(){

        $plats = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Plats')
            ->findAll();
        return $this->render('@embiRestau/Restau/plats.html.twig',array('plats'=>$plats));
    }

    public function editPlatAction($id,Request $request){
        $plat = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Plats')
            ->find($id);

        $form=$this->createFormBuilder($plat)
            ->add('Nom',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px')))
            ->add('Ingredients',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px')))
            ->add('Prix',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:30px')))
            ->add('estDisponible')
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('plats_page');
        }

        return $this->render('@embiRestau/Restau/platModifier.html.twig',array('plat'=>$plat, 'formPlat'=>$form->createView()));
    }


    public function createPlatAction(Request $request){
        $plat=new Plats();
        $form=$this->createFormBuilder($plat)
                    ->add('Nom',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px')))
                    ->add('Ingredients',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px')))
                    ->add('Prix',TextType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:30px')))
                    ->add('estDisponible')
                    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();
            return $this->redirectToRoute('plats_page');
        }
        return $this->render('@embiRestau/Restau/platCreate.html.twig',[
            'formPlat'=>$form->createView()]);

    }
    public function showPlatAction($id){
        $plat = $this->getDoctrine()
        ->getRepository('embiRestauBundle:Plats')
        ->find($id);
        return $this->render('@embiRestau/Restau/platVoir.html.twig',array('plat'=>$plat));
    }
    public function deletePlatAction($id){
        $em = $this->getDoctrine()->getManager();
        $plat = $em->getRepository('embiRestauBundle:Plats')->find($id);
        $em->remove($plat);
        $em->flush();
        return $this->redirectToRoute('plats_page');
    }

    public function commandesAction(){
        $commandes = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Commandes')
            ->findAll();
        return $this->render('@embiRestau/Restau/commandes.html.twig',array('commandes'=>$commandes));
    }

    public function editCommandesAction($id,Request $request){

        $commande = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Commandes')
            ->find($id);

        $form=$this->createFormBuilder($commande)
            ->add('NumeroTable',\Symfony\Component\Form\Extension\Core\Type\IntegerType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px','label'=>'Numéro de table')))
            ->add('surPlace')
            ->add('Plats_id', EntityType::class,['class'=>'embiRestauBundle:Plats','choice_label'=>'Nom','choice_value'=>'Id'])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('commandes_page');
        }

        return $this->render('@embiRestau/Restau/commandesModifier.html.twig',array('formCommande'=>$form->createView()));
    }

    public function createCommandesAction(Request $request){

        //$plat=new Plats();
        /*$plat=array();
        $plats = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Plats')
            ->findAll();
        foreach ($plats as $p){
            $plat[]=$p->getNom();
        }
        */
        $commande=new Commandes();
        $form=$this->createFormBuilder($commande)
            ->add('NumeroTable',\Symfony\Component\Form\Extension\Core\Type\IntegerType::class,array('attr' => array('class' => 'form-control','style' => 'marign-bottom:15px','label'=>'Numéro de table')))
            ->add('surPlace')
            ->add('Plats_id', EntityType::class,['class'=>'embiRestauBundle:Plats','choice_label'=>'Nom','choice_value'=>'Id'])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $commande->setDate(new \DateTime());
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('commandes_page');
        }
        return $this->render('@embiRestau/Restau/commandeCreate.html.twig',[
            'formCommande'=>$form->createView()]);
    }
    public function showCommandesAction($id){
        $commande = $this->getDoctrine()
            ->getRepository('embiRestauBundle:Commandes')
            ->find($id);
        $plat=$this->getDoctrine()
            ->getRepository('embiRestauBundle:Plats')
            ->find($commande->getPlats_id());
        return $this->render('@embiRestau/Restau/commandeVoir.html.twig',array('commande'=>$commande,'plat'=>$plat));
    }
    public function deleteCommandeAction($id){
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('embiRestauBundle:Commandes')->find($id);
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('commandes_page');
    }
}
