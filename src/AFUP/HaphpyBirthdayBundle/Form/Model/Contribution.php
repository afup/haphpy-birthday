<?php

namespace AFUP\HaphpyBirthdayBundle\Form\Model;

use AFUP\HaphpyBirthdayBundle\Validator\Constraints\HaphpyMedia as AssertHaphpyMedia;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contribution
 *
 * @author Faun <woecifaun@gmail.com>
 */
class Contribution
{
    /**
     * @AssertHaphpyMedia(
     *     maxSize="25Mi",
     *     mimeTypes = {
     *         "video/quicktime",
     *         "video/mp4",
     *         "image/jpg",
     *         "image/jpeg",
     *         "image/png",
     *     },
     *     minWidth=800,
     *     minHeight=450,
     *     maxRatio=2,
     *     minRatio=1.5
     * )
     * @Assert\NotNull()
     */
    public $file;

    /**
     * @Assert\NotNull()
     */
    public $creditWanted;
}
