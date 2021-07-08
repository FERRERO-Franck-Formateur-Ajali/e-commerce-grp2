<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommentType;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/{id}", name="show_produit")
     */
    public function show($id, Request $request, EntityManagerInterface $manager): Response
    {
        $repo = $this->getDoctrine()->getRepository(Produits::class);

        $produit = $repo->find($id);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        $content = 'content';

        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTimeImmutable())
                    ->setContent($content);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('show_produit', ['id' => $produit->getId()]);
        };

        return $this->render('produit/index.html.twig', [
            'produit' => $produit,
            'commentForm' => $form->createView(),
            'controller_name' => 'ProduitController',
        ]);
    }

}
