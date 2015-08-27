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

    /**
     * Find a Contribution based on authProvider / identifier
     *
     * @param  string $authProvider the OAuth service (GitHub, Twitter…)
     * @param  string $identifier   the user uniqid for the OAuth provider
     *
     * @return Contribution
     */
    public function findOneContributionByContributor($authProvider, $identifier)
    {
        $queryBuilder = $this->createQueryBuilder('contribution')
            ->select('contribution')
            ->where('contribution.authProvider = :provider')
            ->andWhere('contribution.identifier =  :identifier')
            ->setParameter('provider', $authProvider)
            ->setParameter('identifier', $identifier);

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get every contribution from Persistence
     *
     * @return Contribution[]
     */
    public function getAllContributions()
    {
        $queryBuilder = $this->createQueryBuilder('contribution')
            ->select('contribution')
            ->orderBy('contribution.visibleName', 'ASC')
            ->addOrderBy('contribution.authProvider', 'ASC');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
