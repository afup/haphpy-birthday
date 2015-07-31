<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Media Controller
 */
class MediaController extends Controller
{
    /**
     * @param Request      $request
     * @param Contribution $contribution
     *
     * @Route(
     *     "/media/{auth}/{identifier}",
     *     name="media_serve",
     *     requirements={
     *         "auth": "github|twitter|facebook"
     *     }
     * )
     * @ParamConverter(
     *     "contribution",
     *     class="AppBundle:Contribution",
     *     options={
     *         "mapping": {
     *             "auth"       = "authProvider",
     *             "identifier" = "identifier"
     *         }
     *     }
     * )
     *
     * @return array for template
     */
    public function serveMediaAction(Request $request, Contribution $contribution)
    {
        $user = $this->getUser();

        // For both following tests, we don't want a redirection to login
        // So we return a raw Response (not throwing AccessDeniedException)

        if ($user === null) {
            return new Response('Unauthorized', 401);
        }

        $authProvider = ($contribution->getAuthProvider() === $user->getAuthProvider());
        $identifier   = ($contribution->getIdentifier() === $user->getUsername());
        if (!($authProvider && $identifier)) {
            return new Response('Access denied', 403);
        }

        $this->get('haphpy.file_attacher')->attachTo($contribution);

        $headers = [
            'Cache-Control'             => 'private',
            'Content-type'              => $contribution->getFile()->getMimeTypeForHtmlPlayer(),
            'Content-Length'            => $contribution->getFile()->getSize(),
            'Content-Transfer-Encoding' => 'binary',
        ];

        return new Response(file_get_contents($contribution->getFile()->getRealPath()), 200, $headers);
    }
}
