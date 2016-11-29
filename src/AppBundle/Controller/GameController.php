<?php

namespace AppBundle\Controller;

use AppBundle\Repository\FactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Fact;

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


        return $this->json($response);
    }



}