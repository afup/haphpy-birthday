<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class User extends OAuthUser
{
    /**
     * @var string
     */
     private $resourceOwner;

    /**
     * Get the value of Resource Owner
     *
     * @return string
     */
    public function getResourceOwner()
    {
        return $this->resourceOwner;
    }

    /**
     * Set the value of Resource Owner
     *
     * @param string $resourceOwner
     *
     * @return self
     */
    public function setResourceOwner($resourceOwner)
    {
        $this->resourceOwner = $resourceOwner;

        return $this;
    }
}
