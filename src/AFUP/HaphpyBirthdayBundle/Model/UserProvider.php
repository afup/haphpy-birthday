<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use AFUP\HaphpyBirthdayBundle\Model\User;
use AFUP\HaphpyBirthdayBundle\Service\AdminEnabler;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class UserProvider extends OAuthUserProvider
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Service granting ROLE_ADMIN to user if in admin list
     *
     * @var AdminEnabler
     */
    protected $adminEnabler;

    /**
     * Construct
     *
     * @param SessionInterface $session
     * @param AdminEnabler     $adminEnabler
     */
    public function __construct(SessionInterface $session, AdminEnabler $adminEnabler)
    {
        $this->session = $session;
        $this->adminEnabler = $adminEnabler;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = new User($username);

        if ($username === $this->session->get('username')) {
            $user->setAuthProvider($this->session->get('owner'));
            $user->setVisibleName($this->session->get('visibleName'));
        }
        $this->adminEnabler->grantRoleAdmin($user);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $authProviderName = $response->getResourceOwner()->getName();

        switch ($authProviderName) {
            case 'github':
                $username    = $response->getResponse()['login'];
                $visibleName = $response->getResponse()['name'];
                break;
            case 'twitter':
                $username    = $response->getResponse()['screen_name'];
                $visibleName = $response->getResponse()['name'];
                break;
            case 'facebook':
                $username    = $response->getResponse()['id'];
                $visibleName = $response->getResponse()['name'];
                break;
        }

        $this->session->set('owner', $authProviderName);
        $this->session->set('visibleName', $visibleName);
        $this->session->set('username', $username);

        return $this->loadUserByUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'AFUP\\HaphpyBirthdayBundle\\Model\\User';
    }
}
