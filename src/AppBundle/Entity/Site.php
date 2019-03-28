<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Site
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 */
class Site
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Type(type="string", message="Champ invalide")
     * @ORM\Column(name="nom_site", type="string", length=30)
     */
    private $nomSite;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sortie", mappedBy="site")
     */
    private $sorties;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Participant", mappedBy="site")
     */
    private $participants;

    public function __toString()
    {
        return (string) $this->getNomSite();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomSite
     *
     * @param string $nomSite
     *
     * @return Site
     */
    public function setNomSite($nomSite)
    {
        $this->nomSite = $nomSite;

        return $this;
    }

    /**
     * Get nomSite
     *
     * @return string
     */
    public function getNomSite()
    {
        return $this->nomSite;
    }

    /**
     * @return mixed
     */
    public function getSorties()
    {
        return $this->sorties;
    }

    /**
     * @param mixed $sorties
     * @return Site
     */
    public function setSorties($sorties)
    {
        $this->sorties = $sorties;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     * @return Site
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
        return $this;
    }


}

