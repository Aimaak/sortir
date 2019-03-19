<?php
/**
 * Created by PhpStorm.
 * User: kkocko2018
 * Date: 18/03/2019
 * Time: 11:29
 */

namespace AppBundle\Controller;


use AppBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MenuController extends Controller
{
    /**
     * @Route("/", name="connexion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexionAction(AuthenticationUtils $authenticationUtils){

        // Création du formulaire de connexion
        $form = $this->createForm(LoginType::class);

        // Obtenir la dernière erreur d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();

        // Obtenir le dernier identifiant testé
        $lastUsername = $authenticationUtils->getLastUsername();

        if (!empty($lastUsername)) {
            $form->get('password')->setData($lastUsername);
        }

        return $this->render('participant/connexion.html.twig', [
            'error'=>$error,
            'lastUsername'=>$lastUsername,
            'form' => $form->createView()
        ]);

        return $this->render('menu/accueil.html.twig');
    }

    /**
     * @Route("/accueil", name="accueil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accueilAction(){
        return $this->render('menu/accueil.html.twig');
    }
}