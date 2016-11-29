<?php

namespace AppBundle\Controller;


class GameController extends Controller
{
    /**
     * @Route("/leaderboard/getbetter", name="leaderboardGetbetter")
     */
    public function initGameAction()
    {


        $facts = $this->getDoctrine()
            ->getRepository('AppBundle:Fact')->findFactsForGame();

        $factsFetcher = $this->get('facts_fetcher');
        $responseall = $factsFetcher->fetchFacts($facts);

        $response = array();
        $response["root"] = $responseall['response_root'];
        $response["questions"] = $responseall['response_question'];


        return $this->json($response);
    }



}