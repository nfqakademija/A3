<?php
namespace AppBundle\Game;

use AppBundle\Entity\Fact;
use AppBundle\Utilities\Formatter;

class FactsFetcher
{

    private $facts;
    private $numberOfQuestions;
    private $time;
    private $beginPercentage;
    private $endPercentage;

    public function __construct(int $numberOfQuestions, int $time, int $beginPercentage, int $endPercentage)
    {
        $this->numberOfQuestions = $numberOfQuestions;
        $this->time = $time;
        $this->beginPercentage = $beginPercentage;
        $this->endPercentage = $endPercentage;
    }

    public function fetchFacts(array $facts):array
    {
        $this->facts = $facts;
        $count = count($this->facts);  //counts facts

        $root = $this->getRootIndex($count);

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


        $beforeRoot = array_slice($this->facts, 0, $root);
        $q_array_before = $this->getRandomQuestions($beforeRoot, $q_before);
        $afterRoot = array_slice($this->facts, $root + 1);
        $q_array_after = $this->getRandomQuestions($afterRoot, $q_after);

        $response_root = $this->factsResponse($this->facts[$root]);
        $response_questions = array_merge(
            $this->formatFacts($q_array_before, true),
            $this->formatFacts($q_array_after, false)
        );

        shuffle($response_questions);

        return [
            'response_question' => $response_questions,
            'response_root' => $response_root,
            'response_time' => $this->time
        ];
    }

    private function formatFacts(array $q_array, bool $isBefore):array
    {
        $response_questions = [];
        foreach ($q_array as $before_fact) {
            $response_question = $this->factsResponse($before_fact);
            $response_question ["is_before"] = $isBefore;
            $response_questions[] = $response_question;

        }
        return $response_questions;
    }

    private function factsResponse(Fact $fact):array
    {
        $response = array(
            "id" => $fact->getId(),
            "name" => $fact->getName(),
            "date" => Formatter::formatDate($fact),
        );

        return $response;
    }

    private function getRootIndex(int $count):int
    {
        $root_from = intval($count / 100 * $this->beginPercentage);
        $root_to = intval($count / 100 * $this->endPercentage);
        return mt_rand($root_from, $root_to);
    }

    private function getRandomQuestions(array $output, int $questions):array
    {
        $q_array = [];
        for ($i = 0; $i < $questions; $i++) {
            shuffle($output);
            $q_array[] = array_pop($output);
        }
        return $q_array;
    }
}
