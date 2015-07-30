<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\HttpFoundation\File\File;
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
        $relativePath = $this->pathGenerator->generateRelativePath($contribution, $file);
        $file->move(dirname($path), basename($path));

        // Data persistence
        $contribution->setModifiedAt(new \DateTime());
        $contribution->setFileName($relativePath);

        $this->entityManager->persist($contribution);
        $this->entityManager->flush();
    }

    /**
     * @param Contribution $contribution
     */
    public function remove(Contribution $contribution)
    {
        if ($contribution->isNew()) {
            return;
        }

        unlink($this->pathGenerator->generateAbsolutePath($contribution));
        $contribution->setFileName(null);

        $this->entityManager->persist($contribution);
        $this->entityManager->flush();
    }


    /**
     * @param Contribution $contribution
     *
     * @return \SplFileInfo
     */
    public function getFileInfo(Contribution $contribution)
    {
        if ($contribution->isNew()) {
            return null;
        }
        return new File($this->pathGenerator->generateAbsolutePath($contribution));
    }
}
