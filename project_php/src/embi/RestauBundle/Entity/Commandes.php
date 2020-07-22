<?php

namespace embi\RestauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="embi\RestauBundle\Repository\CommandesRepository")
 */
class Commandes
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
     * @var bool
     *
     * @ORM\Column(name="surPlace", type="boolean")
     */
    private $surPlace;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroTable", type="integer", nullable=true)
     */
    private $numeroTable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Plats")
     * @ORM\JoinColumn(name="Plats_id", referencedColumnName="id")
     */
    private $Plats;


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
     * Set surPlace
     *
     * @param boolean $surPlace
     *
     * @return Commandes
     */
    public function setSurPlace($surPlace)
    {
        $this->surPlace = $surPlace;

        return $this;
    }

    /**
     * Get surPlace
     *
     * @return bool
     */
    public function getSurPlace()
    {
        return $this->surPlace;
    }

    /**
     * Set numeroTable
     *
     * @param integer $numeroTable
     *
     * @return Commandes
     */
    public function setNumeroTable($numeroTable)
    {
        $this->numeroTable = $numeroTable;

        return $this;
    }

    /**
     * Get numeroTable
     *
     * @return int
     */
    public function getNumeroTable()
    {
        return $this->numeroTable;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commandes
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getPlats_id(){
        return $this->Plats;
    }
    public function getPlatsid(){
        return $this->Plats;
    }
    public function setPlatsid($Plats){
        $this->Plats=$Plats;
        return $this;
    }
}

