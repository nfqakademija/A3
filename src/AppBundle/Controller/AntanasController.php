<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AntanasController extends Controller
{

    /**
     * @Route("/antanas/index", name="antanas")
     */
    public function newAction()
    {
        return $this->render('antanas/index.html.twig', array(
        'tekstas' => 'Cia Antano puslapis'
        ));
    }
}
