<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Game;

class GameRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBetterCount(Game $game): int
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('COUNT(g)')
            ->from('AppBundle:Game', 'g')
            ->where(
                $qb->expr()->gt('g.score', $game->getScore())
            )
            ->andWhere(
                $qb->expr()->isNotNull('g.username')
            )
            ->getQuery();

        return $result = $query->getSingleScalarResult();
    }

    /**
     * @param int $numberOfLeaders
     * @return Game[]
     */
    public function getBestScores(int $numberOfLeaders):array
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        // select count
        $query = $qb->select('g')
            ->from('AppBundle:Game', 'g')
            ->where(
                $qb->expr()->isNotNull('g.username')
            )
            ->andWhere(
                $qb->expr()->isNotNull('g.score')
            )
            ->setMaxResults($numberOfLeaders)
            ->orderBy('g.score', ' DESC')
            ->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
