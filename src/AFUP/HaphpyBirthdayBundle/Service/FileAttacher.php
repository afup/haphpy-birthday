<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\HttpFoundation\File\File;

/**
 * Generate a HaPHPy File and attach it to the contribution
 *
 * @author Faun <woecifaun@gmail.com>
 */
class FileAttacher
{
    /**
     * @var string
     */
    private $pathGenerator;

    /**
     * Construct
     *
     * @param PathGenerator $pathGenerator
     */
    public function __construct($pathGenerator)
    {
        $this->pathGenerator = $pathGenerator;
    }

    /**
     * Generate a HaPHPy File and attach it to the contribution
     *
     * @param Contribution $contribution
     *
     * @return false|void
     */
    public function attachTo(Contribution $contribution)
    {
        if (!$contribution->getFileName()) {
            return false;
        }

        $absPath = $this->pathGenerator->generateAbsolutePath($contribution);
        $file    = new File($absPath);

        $contribution->setFile($file);
    }
}
