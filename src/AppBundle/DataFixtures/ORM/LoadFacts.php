<?php

namespace AppBundle\DataFixtures\ORM;


class LoadFacts
{

    public function parseFacts()
    {
        $parsed = [];
        $facts = file_get_contents(__DIR__ . '/facts.tsv');
        $fact = explode(PHP_EOL, $facts);
        foreach ($fact as $entry) {
            if ($entry != "") {
                $parsed[] = explode("\t", $entry);
            }
        }

        return $parsed;
    }

}
