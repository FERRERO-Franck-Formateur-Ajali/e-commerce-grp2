<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits_index")
     */
    public function index(ProduitsRepository $produitsRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);
        $produits= $repo->findall();
        
        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
            'controller_name' => 'ProduitsController',
        ]);
    }
}
