<?php

namespace AFUP\HaphpyBirthdayBundle\Tests\Service;

use AFUP\HaphpyBirthdayBundle\Model\User;
use AFUP\HaphpyBirthdayBundle\Service\AdminEnabler;

/**
 * Path generator test
 *
 * @author Faun <woecifaun@gmail.com>
 */
class AdminEnablerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * List of fake admin users (GitHub identifiers)
     *
     * @var []
     */
    protected $admins = ['admin'];

    /**
     * List of different user to test against
     *
     * @var array
     */
    protected $users = [
        ['github', 'admin'],
        ['github', 'user'],
        ['twitter', 'user'],
    ];

    /**
     * Test if path for an uploaded contribution file is ok
     */
    public function testGrantRoleAdmin()
    {
        $adminEnabler = new AdminEnabler($this->admins);

        foreach ($this->users as $list) {
            list($authProvider, $username) = $list;

            $user = new User($username);
            $user->setAuthProvider($authProvider);

            $adminEnabler->grantRoleAdmin($user);

            if ($authProvider == 'github' && in_array($username, $this->admins)) {
                $assert = 'assertTrue';
            } else {
                $assert = 'assertFalse';
            }
            $this->$assert(in_array('ROLE_ADMIN', $user->getRoles()));
        }
    }
}
