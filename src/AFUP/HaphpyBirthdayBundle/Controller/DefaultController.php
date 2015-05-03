<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default Controller
 */
class DefaultController extends Controller
{
    /**
     * @Template()
     *
     * @return array for template
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return [
            'user' => $user,
        ];
    }

    /**
     * In case root path is asked, redirect to best localized home page
     * (Not sure is the best logical behavior)
     *
     * @Route("/", name="redirect")
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction()
    {
        // check language to redirect best localized home page
        $locale = $this->getRequest()->getPreferredLanguage(
            $this->container->getParameter('accepted_languages')
        );
        if (empty($locale)) {
            $locale = $this->getRequest()->getLocale();
        }

        return $this->redirect($this->generateUrl('haphpy_index', array('locale' => $locale)));
    }

}
