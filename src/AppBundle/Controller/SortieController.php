<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 18/03/2019
 * Time: 15:31
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Etat;
use AppBundle\Entity\Lieu;
use AppBundle\Entity\Participant;
use AppBundle\Entity\Site;
use AppBundle\Entity\Sortie;
use AppBundle\Form\LieuType;
use AppBundle\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        if (!empty($request->request->get("dateDebut")) &&
            !empty($request->request->get("dateFin"))) {

            $dateDebut = new \DateTime($request->request->get("dateDebut"));
            $dateFin = new \DateTime($request->request->get("dateFin"));

            $sites = $em->getRepository(Site::class)->findAll();
            $participants = $em->getRepository(Participant::class)->findAll();
            $mesSorties = $em->getRepository(Sortie::class)->getSortiesOrganisateur($id);
            $sortiesPassees = $em->getRepository(Sortie::class)->getSortiesPassees();
            $sortiesSansArchivees = $em->getRepository(Sortie::class)->getSortiesFiltreDate($dateDebut, $dateFin);

            return $this->render('sortie/liste.html.twig', ["sites" => $sites,
                "participants" => $participants,
                "mesSorties" => $mesSorties,
                "sortiesPassees" => $sortiesPassees,
                "sortiesSansArchivees" => $sortiesSansArchivees,
            ]);
        }

        $sites = $em->getRepository(Site::class)->findAll();
        $participants = $em->getRepository(Participant::class)->findAll();
        $mesSorties = $em->getRepository(Sortie::class)->getSortiesOrganisateur($id);
        $sortiesPassees = $em->getRepository(Sortie::class)->getSortiesPassees();
        $sortiesSansArchivees = $em->getRepository(Sortie::class)->getAllExceptArchived();

        foreach ($sortiesSansArchivees as $sortie) {
            $today = new \DateTime('now');
            if ($sortie->getDateCloture() <= $today) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(3));
            }
            if ($sortie->getDateDebut() <= $today) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(4));
            }

            $dateDiff = date_diff($sortie->getDateDebut(), $today);
            if ($dateDiff->days > 1
                && $sortie->getDateDebut() < $today
                && $sortie->getEtat() == $em->getRepository(Etat::class)->find(4)) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(5));
            }
            $em->persist($sortie);
            $em->flush();
        }

        return $this->render('sortie/liste.html.twig', ["sites" => $sites,
            "participants" => $participants,
            "mesSorties" => $mesSorties,
            "sortiesPassees" => $sortiesPassees,
            "sortiesSansArchivees" => $sortiesSansArchivees,
        ]);
    }

    /**
     * @Route("/detail-{id}", name="detailSortie")
     * @param EntityManagerInterface $em
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public
    function voirSortieAction(EntityManagerInterface $em, $id)
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
    public
    function creerSortieAction(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);


        if ($sortieForm->isSubmitted() && $sortieForm->isValid()
            && $sortie->getDateDebut() > $sortie->getDatecloture()) {
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
    public
    function modifierSortieAction(Request $request, EntityManagerInterface $em, $id)
    {
        $sortie = $em->getRepository(Sortie::class)->find($id);
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()
            && $sortie->getDateDebut() > $sortie->getDatecloture()) {

            $sortie->setOrganisateur($this->getUser());


            if ($sortieForm->get('enregistrer')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(1));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie enregistrée avec succès");
                return $this->redirectToRoute("sortie_liste");
            } elseif ($sortieForm->get('Publier_la_sortie')->isClicked()) {
                $sortie->setEtat($em->getRepository(Etat::class)->find(2));
                $em->persist($sortie);
                $em->flush();

                $this->addFlash("success", "Sortie publiée avec succès");
                return $this->redirectToRoute("sortie_liste");
            }
        }
        return $this->render("sortie/modifier.html.twig", [
            "form" => $sortieForm->createView(),
            "sortie" => $sortie
        ]);
    }

    /**
     * @Route("/supprimer-{id}.html", name="supprimer")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function supprimerAction(Request $request, EntityManagerInterface $em, Sortie $sortie)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add("Supprimer", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->remove($sortie);
            $em->flush();

            $this->addFlash("success", "La sortie a bien été supprimée");
            return $this->redirectToRoute("sortie_liste");
        }

        return $this->render("site/supprimer.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/annuler-{id}", name="annuler")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Sortie $sortie
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public
    function annulerAction(Request $request, EntityManagerInterface $em, Sortie $sortie)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add("motif", TextareaType::class,
                array("label" => "Motif :",
                "attr" => ["cols" => "45",
                            "rows" => "10",
                            "required"]))
            ->add("enregistrer", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() &&
            $form->isValid() &&
            !empty($form->getData("motif"))) {
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

    /**
     * @Route("/inscription-{id}", name="inscription")
     * @param Sortie $sortie
     * @param EntityManagerInterface $em
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public
    function inscriptionAction(EntityManagerInterface $em, $id)
    {
        $today = new \DateTime('now');
        $sortie = $em->getRepository(Sortie::class)->find($id);
        $dateLimite = $sortie->getDatecloture();
        $participants = $sortie->getParticipants()->toArray();

        if ($today < $dateLimite
            && count($sortie->getParticipants()) < $sortie->getNbinscriptionsmax()
            && !in_array($this->getUser(), $participants)) {
            $sortie->addParticipants($this->getUser());

            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Votre inscription a bien été enregistrée");
            return $this->redirectToRoute("sortie_liste");
        } else {
            $this->addFlash("error", "Vous ne pouvez plus vous inscrire à cette sortie");
            return $this->redirectToRoute("sortie_liste");
        }
    }

    /**
     * @Route("/desister-{id}", name="desister")
     * @param EntityManagerInterface $em
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public
    function desisterAction(EntityManagerInterface $em, $id)
    {
        $sortie = $em->getRepository(Sortie::class)->find($id);

        $sortie->removeParticipants($this->getUser());

        $em->persist($sortie);
        $em->flush();

        $this->addFlash("success", "Votre inscription a bien été annulée");
        return $this->redirectToRoute("sortie_liste");
    }
}
