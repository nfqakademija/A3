<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FactsController extends Controller
{
    /**
     * @Route("/facts", name="facts")
     */
    public function displayAction()
    {
        return new Response('<h1>veikia game facts</h1>');
    }
}