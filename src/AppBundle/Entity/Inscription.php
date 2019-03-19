<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscriptions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @var int
     *
     * @ORM\Column(name="sorties_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sorties_id;

    /**
     * @var int
     *
     * @ORM\Column(name="participants_id", type="integer")
     * @ORM\CustomIdGenerator(class="AppBundle\Entity\Participant")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $participants_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="datetime")
     */
    private $dateInscription;

    /**
     * @return int
     */
    public function getSortiesId()
    {
        return $this->sorties_id;
    }

    /**
     * @param int $sorties_id
     * @return Inscription
     */
    public function setSortiesId($sorties_id)
    {
        $this->sorties_id = $sorties_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParticipantsId()
    {
        return $this->participants_id;
    }

    /**
     * @param int $participants_id
     * @return Inscription
     */
    public function setParticipantsId($participants_id)
    {
        $this->participants_id = $participants_id;
        return $this;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return Inscription
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }


}

