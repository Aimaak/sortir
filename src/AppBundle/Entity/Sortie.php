<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sortie
 *
 * @ORM\Table(name="sorties")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SortieRepository")
 */
class Sortie
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
     * @Assert\Length(
     *      min = 5,
     *      max = 30,
     *      minMessage = "Le nom de la sortie doit au moins faire 5 caractères",
     *      maxMessage = "Le nom de la sortie ne doit pas faire plus de 30 caractères")
     * @ORM\Column(name="nom", type="string", length=30)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Type(type="datetime", message="Date non valide")
     * @var \DateTime
     * @ORM\Column(name="datedebut", type="datetime")
     */
    private $datedebut;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @var int
     * @Assert\Type(type="float", message="Durée non valide")
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Date()
     * @var \DateTime
     *
     * @ORM\Column(name="datecloture", type="datetime")
     */
    private $datecloture;

    /**
     * @var int
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Type(type="float", message="Format invalide")
     *
     * @ORM\Column(name="nbinscriptionsmax", type="integer")
     */
    private $nbinscriptionsmax;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(
     *      min = 10,
     *      max = 500,
     *      minMessage = "La description de la sortie doit au moins faire 10 caractères",
     *      maxMessage = "La description de la sortie ne doit pas faire plus de 500 caractères")
     * @ORM\Column(name="descriptioninfos", type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @var string
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlPhoto;

    /**
     * @var
     * @Assert\NotBlank(message="Veuillez choisir un lieu")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lieu", inversedBy="sorties")
     */
    private $lieu;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Etat", inversedBy="sorties")
     */
    private $etat;

    /**
     * @var
     * @Assert\NotBlank(message="Veuillez choisir un site")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Site", inversedBy="sorties")
     */
    private $site;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Participant", inversedBy="sortiesOrganisees")
     */
    private $organisateur;

    /**
     * @var Participant
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Participant", inversedBy="sorties")
     * @ORM\JoinTable(name="inscriptions", joinColumns={@ORM\JoinColumn(name="sorties_no_sortie", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="participants_no_participant", referencedColumnName="id")}
     *      ))
     */
    private $participants;

    public function __toString()
    {
        return (string)$this->getOrganisateur();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Sortie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Sortie
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Sortie
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set datecloture
     *
     * @param \DateTime $datecloture
     *
     * @return Sortie
     */
    public function setDatecloture($datecloture)
    {
        $this->datecloture = $datecloture;

        return $this;
    }

    /**
     * Get datecloture
     *
     * @return \DateTime
     */
    public function getDatecloture()
    {
        return $this->datecloture;
    }

    /**
     * Set nbinscriptionsmax
     *
     * @param integer $nbinscriptionsmax
     *
     * @return Sortie
     */
    public function setNbinscriptionsmax($nbinscriptionsmax)
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;

        return $this;
    }

    /**
     * Get nbinscriptionsmax
     *
     * @return int
     */
    public function getNbinscriptionsmax()
    {
        return $this->nbinscriptionsmax;
    }

    /**
     * Set descriptioninfos
     *
     * @param string $descriptioninfos
     *
     * @return Sortie
     */
    public function setDescriptioninfos($descriptioninfos)
    {
        $this->descriptioninfos = $descriptioninfos;

        return $this;
    }

    /**
     * Get descriptioninfos
     *
     * @return string
     */
    public function getDescriptioninfos()
    {
        return $this->descriptioninfos;
    }

    /**
     * Set urlPhoto
     *
     * @param string $urlPhoto
     *
     * @return Sortie
     */
    public function setUrlPhoto($urlPhoto)
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    /**
     * Get urlPhoto
     *
     * @return string
     */
    public function getUrlPhoto()
    {
        return $this->urlPhoto;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     * @return Sortie
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     * @return Sortie
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     * @return Sortie
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     * @return Sortie
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    public function addParticipants($participant)
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }
        return $this;
    }

    public function removeParticipants($participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * @param mixed $sorties_no_sortie
     * @return Sortie
     */
    public function setSortiesNoSortie($sorties_no_sortie)
    {
        $this->sorties_no_sortie = $sorties_no_sortie;
        return $this;
    }


}

