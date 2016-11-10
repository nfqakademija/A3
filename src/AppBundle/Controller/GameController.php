<?php

namespace AppBundle\Controller;

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

                $count = $this


                $fact = $this->getDoctrine()
                    ->getRepository('AppBundle:Fact')
                    ->findAll();
                var_dump($fact);

return new Response;

    }
}