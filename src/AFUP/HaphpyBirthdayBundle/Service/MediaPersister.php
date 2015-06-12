<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

/**
 * Contribution
 *
 * @author Faun <woecifaun@gmail.com>
 */
class MediaPersister
{
    /**
     * Save file to system
     *
     * @param string       $path absolute path (with name & extension)
     * @param \SplFileInfo $file
     *
     * @return string the persisted file path relative to media root directory
     */
    public function persist($path, \SplFileInfo $file)
    {
        $file->move(dirname($path), basename($path));
    }
}
