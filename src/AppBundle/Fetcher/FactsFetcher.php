<?php
namespace AppBundle\Fetcher;
use AppBundle\Entity\Fact;

class FactsFetcher{
    //get root element
    private $facts;


    public function __construct()
    {

    }

    public function fetchFacts($facts)
    {

        $this->facts = $facts;


        $count = count($this->facts);  //counts facts
        $root_from = intval($count / 100 * 20);  //disables first 10% for root
        $root_to = intval($count / 100 * 80);   //disables last 10% for root
        $root = mt_rand($root_from, $root_to);  // gets root element


        $q_count = 5; //set number of questions

        $q_count_half = $q_count / 2;

        //questions by half if even
        if ($q_count % 2 == 0) {
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

        //elseif ($q_before_diff == 0){
        //  $q_after +=1;
        //$q_before -=1;

        //}

        $q_after_diff = $count - $root - $q_after - 1;
        if ($q_after_diff == 0) {
            $q_after -= 1;
            $q_before += 1;
        } elseif ($q_after_diff < 0) {
            $q_before = $q_before - ($q_after_diff);
            $q_after = $q_after + ($q_after_diff);


        }


        //get questions array


        $q_array = array();

        $q_array_before = array();

        $output = array_slice($this->facts, 0, $root);

        for ($i = 0; $i < $q_before; $i++) {

            shuffle($output);
            $t = array_pop($output);
            $q_array_before[] = $t;


        }


        //var_dump($facts);
        //  var_dump(array_keys($q_array_before));
        $q_array_after = array();
        $output = array_slice($this->facts, $root + 1);

        for ($i = 0; $i < $q_after; $i++) {

            shuffle($output);


            $q_array_after[] = array_pop($output);

        }
        // var_dump(array_keys($q_array_after));

        //$q_array = array_merge($q_array_after, $q_array_before);


        $response_root = $this->factsResponse($this->facts[$root]);
        $response_questions = array();

        foreach ($q_array_before as $before_fact) {
            $response_question = $this->factsResponse($before_fact);
            $response_question ["is_before"] = true;
            $response_questions[] = $response_question;

        }

        foreach ($q_array_after as $after_fact) {

            $response_question = $this->factsResponse($after_fact);
            $response_question ["is_before"] = false;
            $response_questions[] = $response_question;
        }




        shuffle($response_questions);



        return ['response_question'=>$response_questions,'response_root'=>$response_root];
    }

    private function factsResponse(Fact $fact)
    {
        $response = array(
            "id" => $fact->getId(),
            "name" => $fact->getName(),
            "has_details" => (bool)$fact->getDescription(),
        );

        return $response;
    }

}
