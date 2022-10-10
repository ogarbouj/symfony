<?php

namespace App\Controller;

use App\Entity\Club1;
use App\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Club1Repository;
use Doctrine\Persistence\ManagerRegistry;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route('/list', name: 'app_formation')]
    public function list()
    {
        $formations = array(array('ref' => 'form147', 'Titre' => 'Formation Symfony
        4','Description'=>'formation pratique',
        'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
        'nb_participants'=>19) ,
        array('ref'=>'form177','Titre'=>'Formation SOA' ,
        'Description'=>'formation
        theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
        'nb_participants'=>0),
        array('ref'=>'form178','Titre'=>'Formation Angular' ,
        'Description'=>'formation
        theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
        'nb_participants'=>12)
           );
return $this->render("club/list.html.twig",array("tabforamtion"=>$formations));





    }



    #[Route('/reservation', name: 'app_reservation')]

    public function reservation(){
        return $this->render("club/reservation.html.twig");
    }


    
    #[Route('/clubtest', name: 'apptest')]
    public function listClub(Club1Repository  $repository)
    {
        // $clubs= $this->getDoctrine()->
        $clubs= $repository->findAll();
        return $this->render("club/clubs.html.twig" ,array("tabclub"=>$clubs));
       
    }

    #[Route('/ajouttest', name: 'ajouttest')]
    public function addClub (ManagerRegistry $docrtine)
    {
        $club =new Club1();
        $club->setName("tennis");
        $club->setDescription("test");
        $club->setAddresse("Arina");
        $em=$docrtine->getManager();

        $em->persist($club);
        $em->flush();
        return new Response("succes");

    }

    #[Route('/uptest/{id}', name: 'uptest')]
    public function update(Club1Repository $repository ,$id, ManagerRegistry $doctrine)
    {
        $club = $repository->find($id);
        $club->setName("clubUPDATE");
        $club->setDescription("update descrtion");
        $em = $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute("apptest");

    }


        #[Route('/romvetest/{id}', name: 'romvetest')]
        public function remove(Club1Repository $repository ,$id, ManagerRegistry $doctrine)
    {
        $club= $repository->find($id);
        $em=$doctrine->getManager();
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("apptest");
    }
    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $doctrine,Request $request)
    {
        $club=  new  Club1();
        $form= $this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if($form->isSubmitted()){

            //$em= $this->getDoctrine()->getManager();
            $em= $doctrine->getManager();
            $em->persist($club);
            $em->flush();
            return  $this->redirectToRoute("add");
        }
        return $this->renderForm("club/add.html.twig",
        array("formClub"=>$form));



    }

    #[Route('/update/{id}', name: 'update')]
    public function updateClub($id,Club1Repository $repo,ManagerRegistry $doctrine,Request $request)
    {
        $club= $repo->find($id);
        $form= $this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em= $this->getDoctrine()->getManager();
            $em= $doctrine->getManager();
            $em->flush();
            //$repo->add($club,true);
            return  $this->redirectToRoute("apptest");
        }
        return $this->renderForm("club/update.html.twig",
            array("formClub"=>$form));



    }

}
