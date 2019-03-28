<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ville
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VilleRepository")
 */
class Ville
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
     * @ORM\Column(name="nom_ville", type="string", length=30)
     */
    private $nomVille;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Type(type="integer", message="Champ invalide")
     * @ORM\Column(name="code_postal", type="string", length=10)
     */
    private $codePostal;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Lieu", mappedBy="ville")
     */
    private $lieux;

    public function __toString()
    {
        return (string) $this->getNomVille();
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
     * Set nomVille
     *
     * @param string $nomVille
     *
     * @return Ville
     */
    public function setNomVille($nomVille)
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    /**
     * Get nomVille
     *
     * @return string
     */
    public function getNomVille()
    {
        return $this->nomVille;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Ville
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @return mixed
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * @param mixed $lieux
     * @return Ville
     */
    public function setLieux($lieux)
    {
        $this->lieux = $lieux;
        return $this;
    }


}

