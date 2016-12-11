<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Repository\FactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Fact;
use \DateTime;

class GameController extends Controller
{
    /**
     * @Route("/game/init", name="gameInit")
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
        $response["time"] = $responseall['response_time'];

        $game = $this->registerGame($response);

        $response["game_id"] = $game->getId();

        return $this->json($response);
    }

    /**
     * @Route("/game/finish", name="gameFinish")
     */
    public function finishGameAction(Request $request)
    {
        $gameId = $request->query->getInt('id');
        $gameSecret = $request->query->get('secret');
        $timeUsed = $request->query->getInt('time_used');
        $questionsAnswered = $request->query->getInt('questions_answered');

        $game = $this->getDoctrine()
            ->getRepository('AppBundle:Game')->getGameByIdAndSecret($gameId, $gameSecret);

        if ($game->getSecret() !== $gameSecret)
            return $this->json(['error' => 'Secret does not match']);

        $now = new DateTime();

        /*if ($now->getTimestamp() - $game->getCreatedOn()->getTimestamp() > ($game->getTimeGiven() + 60))
            return $this->json(['error' => 'The game in database is to old.']);*/


        $game->setTimeUsed($timeUsed);
        $game->setQuestionsAnswered($questionsAnswered);
        $game->setScore($this->getGameScore($game));

        $betterCount = $this->getDoctrine()
            ->getRepository('AppBundle:Game')->getBetterCount($game);

        $game->setCanRegister($betterCount<10);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = [
            'can_register' => $game->getCanRegister(),
            'score' => $game->getScore()
        ];

        return $this->json($response);
    }


    /**
     * @Route("/game/save", name="gameSave")
     */
    public function saveGameAction(Request $request)
    {
        $gameId = $request->request->getInt('id');
        $gameSecret = $request->request->get('secret');
        $username = $request->request->get('username');


        $game = $this->getDoctrine()
            ->getRepository('AppBundle:Game')->getGameByIdAndSecret($gameId, $gameSecret);

        if ($game->getSecret() !== $gameSecret)
            return $this->json(['error' => 'Secret does not match']);

        if(!$game->getCanRegister())
            return $this->json(['error' => 'User can not save his username']);


        $game->setUsername($username);
        $validator = $this->get('validator');
        $errors = $validator->validate($game);

        if (count($errors) > 0)
            throw $this->createNotFoundException('Data passed to query is incorect.');

        $game->setCanRegister(false);

        $em = $this->getDoctrine()->getManager();
        $em->flush();


        $response = [
            'status' => 'success'
        ];

        return $this->json($response);
    }




    /**
     * @param array $response
     * @return Game
     */
    private function registerGame(array $response): Game
    {
        $game = new Game();
        $game->setCreatedOn(new DateTime());
        $game->setTimeGiven($response['time']);
        $game->setQuestionsGiven(count($response['questions']));
        $game->setSecret(
            hash('sha256', $this->getSecret($response))
        );

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();

        if ($game->getId() == null)
            throw $this->createNotFoundException('Could not register a game.');

        return $game;
    }

    /**
     * @param array $response
     * @return string
     */
    private function getSecret(array $response): string
    {
        $stringOfIds = (string)$response['root']['id'];
        foreach ($response["questions"] as $question)
            $stringOfIds .= (string)$question['id'];

        return $stringOfIds;
    }

    /**
     * @param Game $game
     * @return int
     */
    private function getGameScore(Game $game):int
    {
        $questionsPart = $game->getQuestionsAnswered() / $game->getQuestionsGiven();
        $timePart = 1 - ($game->getTimeUsed() / $game->getTimeGiven());

        return $questionsPart * $timePart * 10000;
    }
}

