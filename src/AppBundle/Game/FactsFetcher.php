<?php
namespace AppBundle\Game;

use AppBundle\Entity\Fact;

class FactsFetcher
{
    //get root element
    private $facts;
    private $numberOfQuestions;
    private $time;
    private $beginPercentage;
    private $endPercentage;

    public function __construct($numberOfQuestions, $time, $beginPercentage, $endPercentage)
    {
        $this->numberOfQuestions = $numberOfQuestions;
        $this->time = $time;
        $this->beginPercentage = $beginPercentage;
        $this->endPercentage = $endPercentage;
    }

    public function fetchFacts($facts)
    {
        $this->facts = $facts;
        $count = count($this->facts);  //counts facts
        $root_from = intval($count / 100 * $this->beginPercentage);  //disables first 10% for root
        $root_to = intval($count / 100 * $this->endPercentage);   //disables last 10% for root
        $root = mt_rand($root_from, $root_to);  // gets root element

        $q_count_half = $this->numberOfQuestions / 2;

        //questions by half if even
        if ($this->numberOfQuestions % 2 == 0) {
            $q_before = $q_count_half;
            $q_after = $q_before;

            // if not even
        } else {
            $rand = mt_rand(0, 1);
            if ($rand) {
                $q_before = intval($q_count_half);
                $q_after = $q_before + 1;
            } else {
                $q_before = intval($q_count_half) + 1;
                $q_after = intval($q_count_half);
            }
        }

        $q_before_diff = $root - $q_before;
        if ($q_before_diff < 0) {
            $q_after = $q_after - ($q_before_diff);
            $q_before = $q_before + ($q_before_diff);
        }

        $q_after_diff = $count - $root - $q_after - 1;
        if ($q_after_diff == 0) {
            $q_after -= 1;
            $q_before += 1;
        } elseif ($q_after_diff < 0) {
            $q_before = $q_before - ($q_after_diff);
            $q_after = $q_after + ($q_after_diff);
        }


        $q_array_before = array();

        $output = array_slice($this->facts, 0, $root);

        for ($i = 0; $i < $q_before; $i++) {
            shuffle($output);
            $t = array_pop($output);
            $q_array_before[] = $t;
        }

        $q_array_after = array();
        $output = array_slice($this->facts, $root + 1);

        for ($i = 0; $i < $q_after; $i++) {
            shuffle($output);
            $q_array_after[] = array_pop($output);
        }

        $response_root = $this->factsResponse($this->facts[$root]);

        $response_questions = array_merge(
            $this->formatFacts($q_array_before, true),
            $this->formatFacts($q_array_after, false)
        );

        shuffle($response_questions);

        return ['response_question' => $response_questions, 'response_root' => $response_root,
            'response_time' => $this->time];
    }

    private function formatFacts($q_array, $isBefore)
    {
        $response_questions = [];
        foreach ($q_array as $before_fact) {
            $response_question = $this->factsResponse($before_fact);
            $response_question ["is_before"] = $isBefore;
            $response_questions[] = $response_question;

        }
        return $response_questions;
    }

    private function factsResponse(Fact $fact)
    {
        $response = array(
            "id" => $fact->getId(),
            "name" => $fact->getName(),
            "date" => $this->formatDate($fact),
        );

        return $response;
    }

    private function formatDate($fact)
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
