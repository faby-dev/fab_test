<?php

namespace App\Controller;

use App\Entity\Etudiants;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Form\SearchEtudiantsType;
use App\Repository\EtudiantsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/etudiant/create", name="Create_Etudiants", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $JsonRecu = $request->getContent();
        try{
            $etudiant = $serializer->deserialize($JsonRecu, Etudiants::class, 'json');
            //$etudiant->setDateDeNaissance(new DateTime("2012-04-23T18:25:43.511Z"));
            $errors = $validator->validate($etudiant);
            if(count($errors)>0){
                return $this->json($errors, 400);
            }
            $em->persist($etudiant);
            $em->flush();  
            return $this->json($etudiant, 201, []);   
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }                    
        
         
    }

    /**
     * @Route("/etudiant/avoir", name="Avoirs_Etudiants", methods={"GET"})
     */
    public function recevoir(EtudiantsRepository $EtudiantsRepo)
    {
        $Etudiants = $EtudiantsRepo->findAll();        
        
        return $this->json($Etudiants, 200, []);
    }

    /**
     * @Route("/etudiant/donwload", name="telecharger_pdf")
     */
    public function pdf_donwload()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', "Arial");
    }



}