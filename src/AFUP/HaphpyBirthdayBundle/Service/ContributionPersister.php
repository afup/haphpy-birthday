<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @param UploadedFile $file
     */
    public function persist(Contribution $contribution, UploadedFile $file)
    {
        // Paths
        $absolutePath = $this->pathGenerator->generateAbsolutePath($contribution, $file);
        $relativePath = $this->pathGenerator->generateRelativePath($contribution, $file);

        // File
        $file->move(dirname($absolutePath), basename($absolutePath));

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
        if (!$contribution->getFileName()) {
            return;
        }

        unlink($this->pathGenerator->getFileAbsolutePath($contribution));

        $this->entityManager->remove($contribution);
        $this->entityManager->flush();
    }
}
