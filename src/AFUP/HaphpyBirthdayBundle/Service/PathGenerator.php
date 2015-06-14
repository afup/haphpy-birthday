<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Path generator for contributed file
 *
 * @author Faun <woecifaun@gmail.com>
 */
class PathGenerator
{
    /**
     * Directory on server storing contributed media
     * Each auth provider has its own subdirectory
     *
     * @var string
     */
    private $directory;

    /**
     * Construct
     *
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * Generate file path relative to contributed media directory
     *
     * @param Contribution $contribution
     * @param SplFileInfo  $file
     *
     * @return string
     */
    public function generateAbsolutePath(Contribution $contribution, File $file)
    {
        return
            $this->directory
            .DIRECTORY_SEPARATOR
            .$contribution->getAuthProvider()
            .DIRECTORY_SEPARATOR
            .$contribution->getIdentifier()
            .'.'
            .($file->guessExtension() ? : $file->getExtension());
    }
}
