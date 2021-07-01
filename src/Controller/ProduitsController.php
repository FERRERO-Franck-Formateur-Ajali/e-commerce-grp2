<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\SearchProduitsType;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits_index")
     */
    public function index(ProduitsRepository $produitsRepository, Request $Request): Response
    {   
       // $produits = $produitsRepository->findBy(['active' => Null],5);  
        $produits = $this->getDoctrine()->getRepository(Produits::class)->findall();

        $form = $this ->createForm(SearchProduitsType::class);
        
        $search = $form->handleRequest($Request);

        if($form->isSubmitted() && $form->isValid()){
            // on recherche annonces correponsant aux mots cles
            $produits = $produitsRepository->search($search->get('mots')->getData());
        }

        return $this->render('produits/index.html.twig', [
            'produits' =>  $produits,
            'controller_name' => 'ProduitsController',
            'form'=> $form->createView()
        ]);
    }
}
