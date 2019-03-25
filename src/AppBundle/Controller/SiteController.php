<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 21/03/2019
 * Time: 09:35
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Site;
use AppBundle\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/site", name="site_")
 * Class SiteController
 * @package AppBundle\Controller
 */
class SiteController extends Controller
{
    /**
     * @Route("/", name="liste")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listeAction(EntityManagerInterface $em, Request $request)
    {
        if (!empty($request->get("nomSite"))) {
            $site = new Site();

            $site->setNomSite($request->get("nomSite"));

            $em->persist($site);
            $em->flush();
        }

        $sites = $em->getRepository(Site::class)->findAll();

        return $this->render("site/liste.html.twig", [
            "sites" => $sites
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @Route("/modifier-{id}.html", name="modifier")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifierAction(Request $request, EntityManagerInterface $em, Site $ville)
    {
        $villeForm = $this->createForm(SiteType::class, $ville);

        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "Site modifié avec succès");
            return $this->redirectToRoute("site_liste");
        }

        return $this->render("site/modifier.html.twig", [
            "form" => $villeForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Site $site
     * @Route("/supprimer-{id}.html", name="supprimer")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function supprimerAction(Request $request, EntityManagerInterface $em, Site $site)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add("Supprimer", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->remove($site);
            $em->flush();

            $this->addFlash("success", "Le site a bien été supprimé");
            return $this->redirectToRoute("site_liste");
        }

        return $this->render("site/supprimer.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function ajouterAction(Request $request, EntityManagerInterface $em)
    {
        $site = new Site();
        $sites = $em->getRepository(Site::class)->findAll();
        $siteForm = $this->createForm(SiteType::class, $site);

        $siteForm->handleRequest($request);

        if ($siteForm->isSubmitted()) {
            $em->persist($site);
            $em->flush();

            $this->addFlash("success", "Site enregistré avec succès");
            return $this->redirectToRoute("site_liste");
        }

        return $this->render("site/ajouter.html.twig", [
            "form" => $siteForm->createView(),
            "sites" => $sites
        ]);
    }
}