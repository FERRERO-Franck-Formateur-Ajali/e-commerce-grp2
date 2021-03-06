<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditprofilType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/account/profile", name="account_profile")
     */
    public function indexProfil(Request $request, ManagerRegistry $registry, UserRepository $repository, SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize(
            $this->getUser()->getClient(),
            'json',
            ['groups' => 'show_infos']
        );

        dump($json);

        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->findAll();
        
        return $this->render('account/index.html.twig', [
            'User' => $user,
        ]);
    }
    
    /**
     * @Route("/edit/mon-compte", name="edit_account")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(EditprofilType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if  (null !== $this->getUser()->getEditEmail()) {
                $this->getUser()->setEmail($this->getUser()->getEditEmail());
            }
            if  (null !== $this->getUser()->getConfirmPassword()) {
                $hash = $encoder->encodePassword($this->getUser(), $this->getUser()->getConfirmPassword());
                $this->getUser()->setPassword($hash);
            }

            $manager->persist($this->getUser());
            $manager->flush();

            /* $this->addFlash('messsage', 'profil mis ?? jour'); */  //Alerte flash pour le changement des infos//
            
            return $this->RedirectToRoute('app_logout');
        }

        return $this->render('account/editprofil.html.twig', [
            'form' => $form->createView(), 
        ]);
    }

    /**
     * @Route("/edit/mon-compte/pass", name="edit_pass_account")
     */
    public function editpass(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        if ($request->isMethod('post')){
            $em = $this->getDoctrine()->getManager();
            
            $user = $this->getUser();

            // v??rifier si les deux mot de passes sont identiques //
            if ($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($encoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'votre mot de passe ?? ??t?? mis ?? jour avec succ??s');

                return $this->redirectToRoute('account_profile');
            }
                else{ $this->addFlash('erreur', 'les deux mots de passes ne sont pas identiques');
            }
        }

        return $this->render('account/editpass.html.twig', [
            /*'form' => $form->createView(),*/
        ]);
    }
}
