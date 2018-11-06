<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(
 *      name="team",
 *      indexes={
 *          @ORM\Index(name="fk_league_idx", columns={"league_id"})
 *      }
 * )
 * @ORM\Entity
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="strip", type="string", length=100, nullable=true)
     */
    protected $strip;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="teams")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    protected $league;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return Team
     */
    public function setName(string $name): Team
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getStrip():? string
    {
        return $this->strip;
    }

    /**
     * @param string $strip
     *
     * @return Team
     */
    public function setStrip(string $strip): Team
    {
        $this->strip = $strip;

        return $this;
    }

    /**
     * @return League
     */
    public function getLeague():? League
    {
        return $this->league;
    }

    /**
     * @param League $league
     *
     * @return Team
     */
    public function setLeague(League $league): Team
    {
        $this->league = $league;

        return $this;
    }
}