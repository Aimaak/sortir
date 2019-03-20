<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 18/03/2019
 * Time: 15:31
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Site;
use AppBundle\Entity\Sortie;
use AppBundle\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function listeAction(EntityManagerInterface $em)
    {
        $sites = $em->getRepository(Site::class)->findAll();
        $sorties = $em->getRepository(Sortie::class)->findAll();

        return $this->render('sortie/liste.html.twig', [
            "sorties" => $sorties,
            "sites" => $sites
        ]);
    }

    /**
     * @Route("/detail-{id}", name="detailSortie")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voirSortieAction(EntityManagerInterface $em, $id)
    {
        $sortie = $em->getRepository(Sortie::class)->find($id);

        return $this->render("sortie/voir_sortie.html.twig", [
            "sortie" => $sortie
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

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted()) {
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Idée enregistrée avec succès");
            return $this->redirectToRoute("sortie_liste");
        }

        return $this->render("sortie/ajouter.html.twig", [
            "form" => $sortieForm->createView(),
        ]);

    }
}