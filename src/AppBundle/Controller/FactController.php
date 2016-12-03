<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Fact;

class FactController extends Controller
{
    /**
     *
     * @Route("/facts/{id}", name="facts")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getFactAction($id)
    {

        try {
            $fact = $this->getDoctrine()
                ->getRepository('AppBundle:Fact')->getFactDetails($id);
        } catch (\Exception $e) {
            throw $this->createNotFoundException("Fact  not found");
        }

        $date = $fact->getYear();
        $month = $fact->getMonth();
        $day = $fact->getDay();
        $name = $fact->getName();
        $description = $fact->getDescription();

        if ($month == null) {
            $date = $date . " m.";
        } elseif ($day == null) {
            $date = $date . " m. " . $month . " mėn. ";
        } else {
            $date = $date . " m. " . $month . " mėn. " . $day . " d.";
        }


        $response["fact_info"] = array(
            "date" => $date,
            "name" => $name,
            "description" => $description
        );


        return $this->json($response);
    }
}