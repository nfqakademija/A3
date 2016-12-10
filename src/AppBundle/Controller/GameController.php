<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Repository\FactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @param array $response
     * @return Game
     */
    private function registerGame(array $response): Game
    {
        $game = new Game();
        $game->setCreatedOn(new DateTime());
        $game->setTimeGiven($response['time']);
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
}

