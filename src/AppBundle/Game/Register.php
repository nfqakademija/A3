<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use Doctrine\ORM\EntityManager;

class Register
{

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param array $response
     * @return Game
     * @throws \Exception
     */
    public function registerGame(array $response): Game
    {
        $game = new Game();
        $game->setCreatedOn(new \DateTime());
        $game->setTimeGiven($response['time']);
        $game->setQuestionsGiven(count($response['questions']));
        $game->setSecret(
            $this->getSecret($response)
        );

        $this->em->persist($game);
        $this->em->flush();

        if ($game->getId() == null) {
            throw new \Exception('Could not register a game.');
        }

        return $game;
    }


    /**
     * @param array $response
     * @return string
     */
    private function getSecret(array $response): string
    {
        $stringOfIds = (string)$response['root']['id'];
        foreach ($response["questions"] as $question) {
            $stringOfIds .= (string)$question['id'];
        }

        return hash('sha256', $stringOfIds);
    }
}
