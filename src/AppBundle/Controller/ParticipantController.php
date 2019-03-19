<?php
/**
 * Created by PhpStorm.
 * User: kkocko2018
 * Date: 18/03/2019
 * Time: 11:33
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantController extends Controller
{

    /**
     * @Route("/", name="accueil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accueilAction()
    {
        return $this->render("menu/accueil.html.twig");
    }

    /**
     * @Route("/mon-profil", name="mon_profil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myProfileAction()
    {


        return $this->render('participant/mon_profil.html.twig');
    }

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // Obtenir la dernière erreur d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();

        // Obtenir le dernier identifiant testé
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('participant/connexion.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}