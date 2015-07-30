<?php

namespace AFUP\HaphpyBirthdayBundle\HttpFoundation\File;

/**
 * HaPHPy contribution file
 */
class File extends \Symfony\Component\HttpFoundation\File\File
{
    /**
     * Get MimeType for html player
     *
     * @return string
     */
    public function getMimeTypeForHtmlPlayer()
    {
        $mimeType = parent::getMimeType();

        if ('video/quicktime' == $mimeType) {
            $mimeType = 'video/mp4';
        }

        return $mimeType;
    }
}
