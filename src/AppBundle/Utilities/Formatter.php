<?php

namespace AppBundle\Utilities;

use AppBundle\Entity\Fact;

class Formatter
{

    public static function formatDate(Fact $fact):string
    {
        $date = $fact->getYear();
        $month = $fact->getMonth();
        $day = $fact->getDay();

        if ($month == null) {
            $date = $date . " m.";
        } elseif ($day == null) {
            $date = $date . " m. " . $month . " mėn. ";
        } else {
            $date = $date . " m. " . $month . " mėn. " . $day . " d.";
        }
        return $date;
    }

}