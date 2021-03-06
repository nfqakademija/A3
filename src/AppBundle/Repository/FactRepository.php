<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Fact;

/**
 * FactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 *
 */
class FactRepository extends \Doctrine\ORM\EntityRepository
{
    public function findFactsForGame():array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select("u")
            ->from('AppBundle:Fact', 'u')
            ->orderBy('u.year', 'ASC')
            ->addOrderBy('u.month', 'ASC')
            ->addOrderBy('u.day', 'ASC')
            ->getQuery();

        return $result = $query->getResult();
    }

    public function getFactDetails(int $id):Fact
    {

        $fact = $this->getEntityManager()
            ->getRepository('AppBundle:Fact')
            ->find($id);
        if (!$fact) {
            throw new \Exception("Id not found.");

        }

        return $fact;
    }
}
