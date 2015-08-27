<?php

namespace AFUP\HaphpyBirthdayBundle\Service;

use AFUP\HaphpyBirthdayBundle\Model\User;

/**
 * Role Admin Checker for user
 *
 * @author Faun <woecifaun@gmail.com>
 */
class AdminEnabler
{
    /**
     * List of GitHub identifiers from people allowed to admin site
     *
     * @var array
     */
    private $admins;

    /**
     * Contruct
     *
     * @param identifiers[] $admins
     */
    public function __construct($admins)
    {
        $this->admins = $admins;
    }

    /**
     * Check if user is in the admins list
     *
     * @param User $user
     *
     * @return bool
     */
    public function grantRoleAdmin(User $user)
    {
        if ($user->getAuthProvider() == 'github' && in_array($user->getUsername(), $this->admins)) {
            $user->grantRoleAdmin();
        }
    }
}
