<?php
/**
 * Created by PhpStorm.
 * User: kkocko2018
 * Date: 18/03/2019
 * Time: 11:33
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Participant;
use AppBundle\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantController extends Controller
{
    /**
     * @Route("/", name="login")
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
     * @param Request $request
     * @param EntityManagerInterface $em
     * @Route("/mon-profil/{id}", name="mon_profil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myProfileAction(Request $request, EntityManagerInterface $em, Participant $participant, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(ParticipantType::class, $participant);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $toSavePassword = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setMotdepasse($toSavePassword);

            $em->persist($participant);
            $em->flush();

            $this->addFlash('success', 'Profil modifié !');
            return $this->redirectToRoute('sortie_liste');
        }

        return $this->render('participant/mon_profil.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil-{id}", name="profil_participant")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voirProfilAction()
    {
        return $this->render("participant/voir_profil.html.twig");
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}