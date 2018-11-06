<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * League
 *
 * @ORM\Table(
 *      name="league"
 * )
 * @ORM\Entity
 */
class League
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="league")
     */
    protected $teams;

    /**
     * League constructor.
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return League
     */
    public function setName(string $name): League
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTeams(): ArrayCollection
    {
        return $this->teams;
    }

    /**
     * add team to the league
     *
     * @param Team $team
     *
     * @return League
     */
    public function addTeam(Team $team): League
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * remove team from league
     *
     * @param Team $team
     */
    public function removeTeam(Team $team): void
    {
        $this->teams->removeElement($team);
    }
}