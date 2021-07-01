<?php
namespace App\Controller;

use App\Service\Panier\PanierService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\HttpFoundation\JsonResponse;

class PanierController extends AbstractController
{   
    
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(PanierService $panierService){

        //setcookie('panier',json_encode($panierService->getFullPanier()),time()+60*60*24*30);

        return $this->render('panier/index.html.twig', [
            'items' =>$panierService->getFullPanier(),
            'total' => $panierService->getTotal()
        ]);    
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add(int $id, PanierService $panierService){
        $panierService->add($id);
        return $this->redirectToRoute("panier_index");
    }
    /**
     * @Route("/panier/subst/{id}", name="panier_subst")
     */
    public function subst(int $id, PanierService $panierService){
        $panierService->subst($id);
        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove(int $id, PanierService $panierService){
        $panierService->remove($id);
        return $this->redirectToRoute("panier_index");
    }
}
