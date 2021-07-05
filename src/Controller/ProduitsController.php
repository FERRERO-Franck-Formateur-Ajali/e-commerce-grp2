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
    public function index(Request $Request, ProduitsRepository $produitsRepository): Response
    {   
        $produits = $this->getDoctrine()->getRepository(Produits::class)->findAll();

        $form = $this ->createForm(SearchProduitsType::class);
        $form->handleRequest($Request);

        if($form->isSubmitted() && $form->isValid()){
            // on recherche annonces correponsant aux mots cles
            $produits = $produitsRepository->search($form->get('mots')->getData());
            dump($produits);
        }

        return $this->render('produits/index.html.twig', [
            'produits' =>  $produits,
            'controller_name' => 'ProduitsController',
            'form'=> $form->createView()
        ]);
    }
}
