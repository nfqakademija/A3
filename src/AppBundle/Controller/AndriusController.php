<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AndriusController extends Controller
{
    /**
     * @Route("/andrius", name="andrius")
     */
    public function indexAction(Request $request)
    {
        return $this->render('andrius/index.html.twig', [
            'title' => 'Andriaus puslapis',
            'andrius_itmes' => array(
                'Mėgsta ilgai miegoti',
                'Mėgsta pusryčius',
                'Galbūt moka programuoti'
            ),
        ]);
    }
}
