<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use Symfony\Component\Yaml\Yaml;

/**
 * Pugs
 */
class Pugs
{

    protected $userGroups;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->userGroups = Yaml::parse(file_get_contents($filePath));
    }

    /**
     * @return array
     */
    public function getUserGroups()
    {
       return $this->userGroups;
    }
}
