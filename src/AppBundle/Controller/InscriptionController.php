<?php
/**
 * Created by PhpStorm.
 * User: kkocko2018
 * Date: 22/03/2019
 * Time: 15:27
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Inscription;
use AppBundle\Entity\Sortie;
use AppBundle\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends Controller
{


    /**
     * @Route("sortie/inscription", name="sortie_inscriptionSortie")
     * @param Sortie $sortie
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionSortieAction(Sortie $sortie, Request $request, EntityManagerInterface $em)
    {
        $inscription = new Inscription();
        $formValidation = $this->createForm(InscriptionType::class, $inscription);
        $formValidation->handleRequest($request);

        if ($formValidation->isSubmitted() && $formValidation->isValid())
        {
            $sortie->setOrganisateur($this->getUser());
            $em->persist($inscription);
            $em->flush();

            $this->addFlash('success', 'Votre inscription a été enregistrée.');
            return $this->redirectToRoute('sortie_liste');
        }
        return $this->render('sortie/inscription.html.twig', [
            'formValidation' => $formValidation->createView(),
            'inscription' => $inscription

        ]);
    }


}