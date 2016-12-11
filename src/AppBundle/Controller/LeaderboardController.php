<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Leader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Repository\LeaderRepository;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class LeaderboardController extends Controller
{
    /**
     * @Route("/leaderboard/isbetter/{score}/{time}", name="leaderboardGetbetter")
     */
    public function isBetterAction(int $score, int $time)
    {


        $betterCount = $this->getDoctrine()
            ->getRepository('AppBundle:Leader')->getBetterCount($score, $time);

        $is_better = true;

        if ($betterCount >= 10)
            $is_better = false;

        return $this->json([
            'is_better' => $is_better,
            'better_count' => $betterCount
        ]);
    }

    /**
     * @Route("/leaderboard/save", name="leaderboardSave")
     */
    public function saveLeaderAction(Request $request)
    {
        if (!$request->isXmlHttpRequest() || !$request->isMethod('POST'))
            throw $this->createNotFoundException('This is not an AJAX call.');


        $leader = new Leader();
        $leader->setInsertedOn(new DateTime());
        $leader->setUsername($request->request->get('username'));
        $leader->setScore((int)$request->request->get('score'));
        $leader->setTime((int)$request->request->get('time'));

        $validator = $this->get('validator');
        $errors = $validator->validate($leader);

        if (count($errors) > 0)
            throw $this->createNotFoundException('Data passed to query is incorect.');

        $em = $this->getDoctrine()->getManager();
        $em->persist($leader);
        $em->flush();

        if ($leader->getId() == null)
            throw $this->createNotFoundException('Could not register new leader');

        return $this->json([
            'status' => 'sucess',
            'leader_id' => $leader->getId()
        ]);

    }

    /**
     * @Route("/leaderboard/get", name="leaderboardGet")
     */
    public function getLeaderboardAction()
    {

        $leaders = $this->getDoctrine()
            ->getRepository('AppBundle:Game')->getBestScores(10);

        $leadersArray = [];

        foreach ($leaders as $leader) {
            $leaderItem = [
                'username' => $leader->getUsername(),
                'score' => $leader->getScore()
            ];
            $leadersArray[] = $leaderItem;
        }


        return $this->json(['leaders' => $leadersArray]);
    }


}