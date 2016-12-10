<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="games")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="secret", type="string", length=255)
     */
    private $secret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var bool
     *
     * @ORM\Column(name="can_register", type="boolean")
     */
    private $canRegister = false;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var int
     *
     * @ORM\Column(name="time_given", type="integer")
     */
    private $timeGiven;

    /**
     * @var int
     *
     * @ORM\Column(name="time_used", type="integer", nullable=true)
     */
    private $timeUsed;


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
     * Set secret
     *
     * @param string $secret
     *
     * @return Game
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Game
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set canRegister
     *
     * @param boolean $canRegister
     *
     * @return Game
     */
    public function setCanRegister($canRegister)
    {
        $this->canRegister = $canRegister;

        return $this;
    }

    /**
     * Get canRegister
     *
     * @return bool
     */
    public function getCanRegister()
    {
        return $this->canRegister;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Game
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
     * Set timeGiven
     *
     * @param integer $timeGiven
     *
     * @return Game
     */
    public function setTimeGiven($timeGiven)
    {
        $this->timeGiven = $timeGiven;

        return $this;
    }

    /**
     * Get timeGiven
     *
     * @return integer
     */
    public function getTimeGiven()
    {
        return $this->timeGiven;
    }

    /**
     * Set timeUsed
     *
     * @param integer $timeUsed
     *
     * @return Game
     */
    public function setTimeUsed($timeUsed)
    {
        $this->timeUsed = $timeUsed;

        return $this;
    }

    /**
     * Get timeUsed
     *
     * @return integer
     */
    public function getTimeUsed()
    {
        return $this->timeUsed;
    }
}
