<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

/**
 * HaPHPy Uploaded File for generating fake contributions
 *
 * @author Faun <woecifaun@gmail.com>
 */
class UploadedFile extends SymfonyUploadedFile
{
    /**
     * Moves the file to a new location.
     *
     * @param string $directory The destination folder
     * @param string $name      The new file name
     *
     * @return File A File object representing the new file
     */
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        if (!@rename($this->getPathname(), $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }
}
