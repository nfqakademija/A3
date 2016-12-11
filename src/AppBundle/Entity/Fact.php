<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fact
 *
 * @ORM\Table(name="facts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactRepository")
 */
class Fact
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     *
     */
    private $year;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $month;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $day;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }


    /**
     * @param int $month
     */
    public function setMonth(int $month)
    {
        $this->month = $month;
    }

    /**
     * @param int $day
     */
    public function setDay(int $day)
    {
        $this->day = $day;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getYear():int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription():string
    {
        return $this->description;
    }
}
