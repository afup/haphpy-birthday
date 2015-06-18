<?php

namespace AFUP\HaphpyBirthdayBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Contribution
 *
 * @author Faun <woecifaun@gmail.com>
 */
class ContributionRepository extends EntityRepository
{
    /**
     * Find all contributions where credit is wanted
     * in alphabetical order
     *
     * @return Contribution[]
     */
    public function findPublicContributionsAlphabetically()
    {
        $queryBuilder = $this->createQueryBuilder('contribution')
            ->select('contribution')
            ->where('contribution.creditWanted = true')
            ->orderBy('contribution.identifier', 'ASC')
            ->addOrderBy('contribution.authProvider', 'ASC');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * Count contributions
     *
     * @return int
     */
    public function getContributionsQuantity()
    {
        return $this->createQueryBuilder('contribution')
            ->select('count(contribution.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
