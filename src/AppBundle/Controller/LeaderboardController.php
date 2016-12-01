<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Leader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Repository\LeaderRepository;
use DateTime;

class LeaderboardController extends Controller
{
    /**
     * @Route("/leaderboard/getbetter", name="leaderboardGetbetter")
     */
    public function getBetterAction()
    {


        $betterCount = $this->getDoctrine()
            ->getRepository('AppBundle:Leader')->getBetterCount(40,20);



        return $this->json($betterCount);
    }

    /**
     * @Route("/leaderboard/save/{username}/{score}/{timeSpent}", name="leaderboardSave")
     */
    public function saveLeaderAction($username, $score, $timeSpent)
    {

        $leader = new Leader();

        $leader->setUsername($username);
        $leader->setScore($score);
        $leader->setTime($timeSpent);
        $leader->setInsertedOn(new DateTime());

        $betterCount = $this->getDoctrine()
            ->getRepository('AppBundle:Leader')->save($leader);

        return $this->json($betterCount);
    }

    /**
     * @Route("/leaderboard/get", name="leaderboardGet")
     */
    public function getLeaderboardAction()
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