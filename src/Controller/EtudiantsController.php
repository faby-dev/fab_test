<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Form\SearchEtudiantsType;
use App\Repository\EtudiantsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtudiantsController extends AbstractController{

    /**
     * @Route("/", name="Accueil")
     */
    public function Accueil (EtudiantsRepository $EtudiantsRepo, PaginatorInterface $paginator, Request $request){
        //Pérmet de Trouver tout l'enregistrement a la base de donées
        $Etudiants = $paginator->paginate($EtudiantsRepo->findAll(), $request->query->getInt("page", 1), 10);

        //Pérmet d'affiche la formulaire de recherche
        $form = $this->createForm(SearchEtudiantsType::class);
        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //On recherche les Etudiants correspondant a la mot clés
            $Etudiants = $EtudiantsRepo->Search($search->get('mots')->getData());
        }
        
        return $this->render('Accueil/Accueil.html.twig',[
            "Etudiants" => $Etudiants,
            "FormSearch" => $form->createView()
        ]);
    }

    /**
     * @Route("etudiant/create", name="create_Etudiants")
     */
    public function create(){
        
    }

    /**
     * @Route("etudiant/avoir", name="create_Etudiants", methods={"GET"})
     */
    public function recevoir(EtudiantsRepository $EtudiantsRepo)
    {
        $Etudiants = $EtudiantsRepo->findAll();        
        
        return $this->json($Etudiants, 200, []);
    }

    /**
     * @Route("etudiant/donwload", name="create_Etudiants")
     */
    public function pdf_donwload(){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', "Arial");
    }

}