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
     * @param AuthenticationUtils $authenticationUtils
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
     * @param Participant $participant
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mon-profil/{id}", name="mon_profil")
     */
    public function myProfileAction(Request $request, EntityManagerInterface $em, Participant $participant, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(ParticipantType::class, $participant);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $toSavePassword = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setMotdepasse($toSavePassword);
            $participant->setSalt("!F5e8V45");

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
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voirProfilAction($id, EntityManagerInterface $entityManager)
    {
        $repoParticipants = $entityManager->getRepository(Participant::class);
        $participant = $repoParticipants->find($id);

        if(empty($participant)){
            throw $this->createNotFoundException('Participant inconnu !');
        }

        return $this->render("participant/voir_profil.html.twig", [
            'participant' => $participant
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}