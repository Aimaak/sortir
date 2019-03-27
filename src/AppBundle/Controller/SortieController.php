<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 18/03/2019
 * Time: 15:31
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Etat;
use AppBundle\Entity\Participant;
use AppBundle\Entity\Site;
use AppBundle\Entity\Sortie;
use AppBundle\Form\SortieType;
use AppBundle\Form\ValidationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie", name="sortie_")
 * Class SortieController
 * @package AppBundle\Controller
 */
class SortieController extends Controller
{

    /**
     * @Route("/", name="liste")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listeAction(EntityManagerInterface $em, Request $request)
    {
        $id = $this->getUser()->getId();
        $sites = $em->getRepository(Site::class)->findAll();
        $sorties = $em->getRepository(Sortie::class)->findAll();
        $participants = $em->getRepository(Participant::class)->findAll();
        $mesSorties = $em->getRepository(Sortie::class)->getSortiesOrganisateur($id);
        $sortiesPassees = $em->getRepository(Sortie::class)->getSortiesPassees();
        //$sortiesInscrit = $em->getRepository(Sortie::class)->getSortiesInscrit($id);

        $filtreInscrit = $request->get("filtreInscrit");
        $filtreNonInscrit = $request->get("filtreNonInscrit");

        return $this->render('sortie/liste.html.twig', [
            "sorties" => $sorties,
            "sites" => $sites,
            "participants" => $participants,
            "mesSorties" => $mesSorties,
            "sortiesPassees" => $sortiesPassees,
            //"sortiesInscrit" => $sortiesInscrit
        ]);
    }

    /**
     * @Route("/detail-{id}", name="detailSortie")
     * @param EntityManagerInterface $em
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voirSortieAction(EntityManagerInterface $em, $id)
    {
        $sortie = $em->getRepository(Sortie::class)->find($id);
        $participants = $sortie->getParticipants();


        return $this->render("sortie/voir_sortie.html.twig", [
            "sortie" => $sortie,
            "participants" => $participants
        ]);
    }

    /**
     * @Route("/creer", name="creerSortie")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function creerSortieAction(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->remove('Supprimer la sortie');
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $sortie->setOrganisateur($this->getUser());

            if ($sortieForm->get('enregistrer')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(1));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie enregistrée avec succès");
                return $this->redirectToRoute("sortie_liste");
            } else {
                $sortie->setEtat($em->getRepository(Etat::class)->find(2));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie publiée avec succès");
                return $this->redirectToRoute("sortie_liste");
            }

        }

        return $this->render("sortie/ajouter.html.twig", [
            "form" => $sortieForm->createView(),
        ]);

    }

    /**
     * @Route("/modifier-{id}", name="modifierSortie")
     * @param Sortie $sortie
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function modifierSortieAction(Sortie $sortie, Request $request, EntityManagerInterface $em, $id)
    {
        $sortie = $em->getRepository(Sortie::class)->find($id);
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

            $sortie->setOrganisateur($this->getUser());


            if ($sortieForm->get('enregistrer')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(1));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie enregistrée avec succès");
                return $this->redirectToRoute("sortie_liste");
            } elseif ($sortieForm->get('Publier la sortie')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(2));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie publiée avec succès");
                return $this->redirectToRoute("sortie_liste");
            } else {

                $em->remove($sortie);
                $em->flush();

                $this->addFlash('success', 'Sortie supprimée avec succès');
                return $this->redirectToRoute("sortie_liste");
            }

        }
        return $this->render("sortie/modifier.html.twig", [
            "form" => $sortieForm->createView(),
        ]);
    }

    /**
     * @Route("/annuler-{id}", name="annuler")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function annulerAction(Request $request, EntityManagerInterface $em, Sortie $sortie)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add("enregistrer", SubmitType::class)
            ->add("annuler", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('enregistrer')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(6));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "La sortie a bien été annulée");
                return $this->redirectToRoute("sortie_liste");
            } elseif ($form->get('annuler')->isClicked()) {
                return $this->redirectToRoute("sortie_liste");
            }
        }

        return $this->render("sortie/annuler.html.twig", [
            "form" => $form->createView(),
            "sortie" => $sortie
        ]);
    }
}
