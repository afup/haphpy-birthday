<?php

namespace AFUP\HaphpyBirthdayBundle\HttpFoundation\File;

class File extends \Symfony\Component\HttpFoundation\File\File
{
    /**
     * @return bool
     */
    public function isImage()
    {
        return 0 === strpos($this->getMimeType(), 'image/');
    }

} 
