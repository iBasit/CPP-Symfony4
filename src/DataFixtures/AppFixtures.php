<?php

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $league = new League();
        $league->setName('champion');

        $league2 = new League();
        $league2->setName('tournament');

        $team = new Team();
        $team
            ->setName('west side team')
            ->setStrip('blue')
            ->setLeague($league);

        $team2 = new Team();
        $team2
            ->setName('east side team')
            ->setStrip('red')
            ->setLeague($league);

        $team3 = new Team();
        $team3
            ->setName('south side team')
            ->setStrip('yellow')
            ->setLeague($league);

        $team4 = new Team();
        $team4
            ->setName('north side team')
            ->setStrip('grey')
            ->setLeague($league);

        $team5 = new Team();
        $team5
            ->setName('strom team')
            ->setStrip('gold')
            ->setLeague($league2);


        $manager->persist($league);
        $manager->persist($league2);
        $manager->persist($team);
        $manager->persist($team2);
        $manager->persist($team3);
        $manager->persist($team4);
        $manager->persist($team5);
        $manager->flush();
    }
}
