<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Leader
 *
 * @ORM\Table(name="leaders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeaderRepository")
 */
class Leader
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
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Regex("/[a-zA-Z0-9]*$/")
     * @Assert\Length(
     *     min = 2,
     *     max = 50
     * )
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $score;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $time;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inserted_on", type="datetime")
     */
    private $insertedOn;


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
     * Set username
     *
     * @param string $username
     *
     * @return Leader
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Leader
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Leader
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set insertedOn
     *
     * @param \DateTime $insertedOn
     *
     * @return Leader
     */
    public function setInsertedOn($insertedOn)
    {
        $this->insertedOn = $insertedOn;

        return $this;
    }

    /**
     * Get insertedOn
     *
     * @return \DateTime
     */
    public function getInsertedOn()
    {
        return $this->insertedOn;
    }
}

