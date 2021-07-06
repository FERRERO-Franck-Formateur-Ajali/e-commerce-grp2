<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/{id}", name="show_produit")
     */
    public function show($id): Response
    {
        $repo =$this->getDoctrine()->getRepository(Produits::class);

        $produit = $repo->find($id);

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
            'controller_name' => 'ProduitController',
        ]);
    }
}
