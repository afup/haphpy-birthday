<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contribution Persister
 * Move uploaded file to contribution directory
 * as well as persist contribution info to db
 *
 * @author Faun <woecifaun@gmail.com>
 */
class ContributionPersister
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PathGenerator
     */
    private $pathGenerator;

    /**
     * Construct
     *
     * @param EntityManagerInterface $entityManager
     * @param PathGenerator          $pathGenerator
     */
    public function __construct(EntityManagerInterface $entityManager, PathGenerator $pathGenerator)
    {
        $this->entityManager = $entityManager;
        $this->pathGenerator = $pathGenerator;
    }

    /**
     * Save Contribution file to file system
     * and perist Contribution info to database
     *
     * @param Contribution $contribution
     * @param \SplFileInfo $file
     */
    public function persist(Contribution $contribution, \SplFileInfo $file)
    {
        // File
        $path = $this->pathGenerator->generateAbsolutePath($contribution, $file);
        $file->move(dirname($path), basename($path));

        // Data persistence
        $contribution->setModifiedAt(new \DateTime());
        $this->entityManager->persist($contribution);
        $this->entityManager->flush();
    }
}
