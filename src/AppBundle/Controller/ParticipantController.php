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

class ParticipantController extends Controller
{
    /**
     * @Route("/mon-profil", name="mon_profil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myProfileAction()
    {


        return $this->render('participant/mon_profil.html.twig');
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logoutAction(){

    }


}