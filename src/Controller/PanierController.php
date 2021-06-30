<?php
namespace App\Controller;

use App\Service\Panier\PanierService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(PanierService $panierService){
        return $this->render('panier/index.html.twig', [
            'items' => $panierService->getFullPanier(),
            'total' => $panierService->getTotal()
        ]);    
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, PanierService $panierService){
        $panierService->add($id);
        return $this->redirectToRoute("panier_index");
    }
    /**
     * @Route("/panier/subst/{id}", name="panier_subst")
     */
    public function subst($id, PanierService $panierService){
        $panierService->subst($id);
        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, PanierService $panierService){
        $panierService->remove($id);
        return $this->redirectToRoute("panier_index");
    }
}
