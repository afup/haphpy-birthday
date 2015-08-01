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
     * @param File         $file
     *
     * @return string
     */
    public function generateAbsolutePath(Contribution $contribution, File $file = null)
    {
        if (null === $file) {
            return $this->directory.DIRECTORY_SEPARATOR.$contribution->getFileName();
        }

        return $this->directory.DIRECTORY_SEPARATOR.$this->generateRelativePath($contribution, $file);
    }

    /**
     * @param Contribution $contribution
     * @param File         $file
     *
     * @return string
     */
    public function generateRelativePath(Contribution $contribution, File $file)
    {
        $path  = $contribution->getAuthProvider().DIRECTORY_SEPARATOR;
        $path .= $contribution->getIdentifier();
        $path .= '.'.($file->guessExtension() ? : $file->getExtension());

        return $path;
    }
}
