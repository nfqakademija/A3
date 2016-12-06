<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Leader;


class LeaderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $score
     * @param int $timeSpent
     * @return int
     */
    public function getBetterCount(int $score, int $timeSpent): int
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        // select count
        $query = $qb->select('COUNT(l)')
            ->from('AppBundle:Leader', 'l')
            ->where(
                $qb->expr()->gt('l.score', $score)
            )
            ->andWhere(
                $qb->expr()->lt('l.time', $timeSpent)
            )
            ->getQuery();
        $result = $query->getSingleScalarResult();

        return $result;
    }

    /**
     * @param Leader $leader
     */
    public function save(Leader $leader)
    {
        $em = $this->getEntityManager();

        $em->persist($leader);

        $em->flush();
    }

    /**
     * @param int $numberOfLeaders
     * @return array
     */
    public function get(int $numberOfLeaders): array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        // select count
        $query = $qb->select('l')
            ->from('AppBundle:Leader', 'l')
            ->setMaxResults($numberOfLeaders)
            ->orderBy('l.score', ' DESC')
            ->addOrderBy('l.time', 'ASC')
            ->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
