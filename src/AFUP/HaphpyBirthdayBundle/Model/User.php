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
     private $authProvider;

    /**
     * Get the value of Resource Owner
     *
     * @return string
     */
    public function getAuthProvider()
    {
        return $this->authProvider;
    }

    /**
     * Set the value of Resource Owner
     *
     * @param string $authProvider
     *
     * @return self
     */
    public function setAuthProvider($authProvider)
    {
        $this->authProvider = $authProvider;

        return $this;
    }
}
