<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/game")
 */

class GameController extends Controller
{
    /**
     * @Route("/init", name="homepage")
     */
    public function initGameAction()
    {



    }
}