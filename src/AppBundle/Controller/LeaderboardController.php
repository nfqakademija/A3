<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeaderboardController extends Controller
{
    /**
     * @Route("/leaderboard/get", name="leaderboardGet")
     */
    public function getLeaderboardAction()
    {
        $leaders = $this->getDoctrine()->getRepository('AppBundle:Game')->getBestScores(10);

        $leadersArray = [];

        foreach ($leaders as $leader) {
            $leaderItem = [
                'username' => htmlspecialchars($leader->getUsername()),
                'score' => $leader->getScore()
            ];
            $leadersArray[] = $leaderItem;
        }

        return $this->json([
            'status' => 'success',
            'leaders' => $leadersArray
        ]);
    }
}
