<?php
/**
 * Created by PhpStorm.
 * User: yboucher2018
 * Date: 21/03/2019
 * Time: 09:35
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function listeAction(EntityManagerInterface $em)
    {
        $sites = $em->getRepository(Site::class)->findAll();

        return $this->render("site/liste.html.twig", [
            "sites" => $sites
        ]);
    }
}