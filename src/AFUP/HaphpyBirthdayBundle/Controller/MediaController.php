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
     *     "/media/{authProvider}/{identifier}",
     *     name="media_serve",
     *     requirements={
     *         "authProvider": "g|f|t"
     *     }
     * )
     * @ParamConverter(converter="public_contribution")
     *
     * @return array for template
     */
    public function serveMediaAction(Request $request, Contribution $contribution)
    {
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
