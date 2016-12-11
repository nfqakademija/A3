<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Game;
use AppBundle\Repository\FactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Fact;
use \DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

        if (!$request->isXmlHttpRequest() || !$request->isMethod('GET'))
            throw new BadRequestHttpException('This is not an AJAX request!');

        $gameId = $request->query->getInt('id');
        $gameSecret = $request->query->get('secret');
        $timeUsed = $request->query->getInt('time_used');
        $questionsAnswered = $request->query->getInt('questions_answered');

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $game = $em->find('AppBundle:Game', $gameId);
        $game->setTimeUsed($timeUsed);
        $game->setQuestionsAnswered($questionsAnswered);
        $game->setScore($this->getGameScore($game));

        $betterCount = $doctrine
            ->getRepository('AppBundle:Game')->getBetterCount($game);

        $game->setCanRegister($betterCount<10);

        if ($game->getSecret() !== $gameSecret){
            return $this->json([
                'status' => 'fail',
                'error' => 'Secret does not match'
            ]);
        }

        $now = new DateTime();

        if ($now->getTimestamp() - $game->getCreatedOn()->getTimestamp() > ($game->getTimeGiven() + 60)){
            return $this->json([
                'status' => 'fail',
                'error' => 'The game in database is to old.'
            ]);
        }

        if ($game->getQuestionsGiven() < $game->getQuestionsAnswered()){
            return $this->json([
                'status' => 'fail',
                'error' => 'User can\'t answer more questions than there is given to him.'
            ]);
        }

        if ($game->getQuestionsGiven() < $game->getQuestionsAnswered()){
            return $this->json([
                'status' => 'fail',
                'error' => 'User can\'t anwer more questions than there is given to him'
            ]);
        }


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = [
            'status' => 'success',
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

        if (!$request->isXmlHttpRequest() || !$request->isMethod('POST'))
            throw new BadRequestHttpException('This is not an AJAX request!');

        $gameId = $request->request->getInt('id');
        $gameSecret = $request->request->get('secret');
        $username = $request->request->get('username');

        $doctrine = $this->getDoctrine();

        $game = $doctrine
            ->getRepository('AppBundle:Game')->getGameByIdAndSecret($gameId, $gameSecret);

        if ($game->getSecret() !== $gameSecret){
            return $this->json([
                'status' => 'fail',
                'error' => 'Secret does not match'
            ]);
        }


        if(!$game->getCanRegister()){
            return $this->json([
                'status' => 'fail',
                'error' => 'User can not save his username'
            ]);
        }



        $game->setUsername($username);
        $game->setCanRegister(false);

        $validator = $this->get('validator');
        $errors = $validator->validate($game);

        if (count($errors) > 0){
            return $this->json([
                'status' => 'fail',
                'error' => 'Data passed to query is incorect.'
            ]);
        }

        $em = $doctrine->getManager();
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
             $this->getSecret($response)
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

        return  hash('sha256', $stringOfIds);
    }

    /**
     * @param Game $game
     * @return int
     */
    private function getGameScore(Game $game):int
    {
        $questionsPart = $game->getQuestionsAnswered() / $game->getQuestionsGiven();
        $timePart = (1 - ($game->getTimeUsed() / $game->getTimeGiven())) * 0.1;

        return ($questionsPart + $timePart ) * 10000;
    }
}

