<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use AFUP\HaphpyBirthdayBundle\Model\User;
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
     * Construct
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = new User($username);

        if ($username === $this->session->get('username')) {
            $user->setResourceOwner($this->session->get('owner'));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();
        $username          = $response->getResponse()['login'];

        $this->session->set('owner', $resourceOwnerName);
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
