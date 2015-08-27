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
     * Whether the current user is granted ROLE_ADMIN
     *
     * @var bool
     */
    private $isAdmin;

    /**
     * @var string
     */
    private $authProvider;

    /**
     * @var string
     */
    private $visibleName;

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

    /**
     * Gets the value of visibleName.
     *
     * @return string
     */
    public function getVisibleName()
    {
        return $this->visibleName;
    }

    /**
     * Sets the value of visibleName.
     *
     * @param string $visibleName
     *
     * @return self
     */
    public function setVisibleName($visibleName)
    {
        $this->visibleName = $visibleName;

        return $this;
    }

    /**
     * Grant ROLE_ADMIN to user
     */
    public function grantRoleAdmin()
    {
        $this->isAdmin = true;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $roles = ['ROLE_USER', 'ROLE_OAUTH_USER'];

        if ($this->isAdmin) {
            array_push($roles, 'ROLE_ADMIN');
        }

        return $roles;
    }
}
