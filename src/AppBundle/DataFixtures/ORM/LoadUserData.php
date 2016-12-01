<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Fact;
use AppBundle\DataFixtures\ORM\LoadFacts;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $call = new LoadFacts();
        $lines = $call->parseFacts();

        foreach ($lines as $entry) {
            $fact = new Fact();

            $fact->setYear($entry[0]);
            if ($entry[1]!=null)
            {
                $fact->setMonth($entry[1]);
            }
            if ($entry[2]!=null)
            {
                $fact->setDay($entry[2]);
            }
            $fact->setName($entry[3]);
            if ($entry[4]!=null)
            {
                $fact->setDescription($entry[4]);
            }

            $manager->persist($fact);
        }

        $manager->flush();
    }
}

