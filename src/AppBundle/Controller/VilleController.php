<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 21/03/2019
 * Time: 09:35
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Ville;
use AppBundle\Form\SortieType;
use AppBundle\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ville", name="ville_")
 * Class VilleController
 * @package AppBundle\Controller
 */
class VilleController extends Controller
{

    /**
     * @Route("/", name="liste")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listeAction(EntityManagerInterface $em)
    {
        $villes = $em->getRepository(Ville::class)->findAll();

        return $this->render("ville/liste.html.twig", [
            "villes" => $villes
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @Route("/modifier-{id}.html", name="modifier")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modifierAction(Request $request, EntityManagerInterface $em, Ville $ville)
    {
        $villeForm = $this->createForm(VilleType::class, $ville);

        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "Ville modifiée avec succès");
            return $this->redirectToRoute("ville_liste");
        }

        return $this->render("ville/modifier.html.twig", [
            "form" => $villeForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Ville $ville
     * @Route("/supprimer-{id}.html", name="supprimer")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function supprimerAction(Request $request, EntityManagerInterface $em, Ville $idea)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add("Supprimer", SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->remove($idea);
            $em->flush();

            $this->addFlash("success", "La ville a bien été supprimée");
            return $this->redirectToRoute("ville_liste");
        }

        return $this->render("ville/supprimer.html.twig", [
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
        $ville = new Ville();
        $villes = $em->getRepository(Ville::class)->findAll();
        $villeForm = $this->createForm(VilleType::class, $ville);

        $villeForm->handleRequest($request);

        if ($villeForm->isSubmitted()) {
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "Ville enregistrée avec succès");
            return $this->redirectToRoute("ville_liste");
        }

        return $this->render("ville/ajouter.html.twig", [
            "form" => $villeForm->createView(),
            "villes" => $villes
        ]);
    }

}