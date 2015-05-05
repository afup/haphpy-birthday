<?php

namespace AFUP\HaphpyBirthdayBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class Contribution
{
    /**
     * @Assert\File(
     *     maxSize="6Mi",
     *     mimeTypes = {
     *         "video/quicktime",
     *         "video/mp4",
     *         "image/jpg",
     *         "image/jpeg",
     *         "image/png",
     *     }
     * )
     * @Assert\NotNull()
     */
    public $file;

    /**
     * @Assert\NotNull()
     */
    public $websiteCreditWanted;

    /**
     * Assert\NotNull()
     */
    // public $videoCreditWanted;
}
