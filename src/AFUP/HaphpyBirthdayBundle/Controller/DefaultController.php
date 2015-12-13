<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\HttpFoundation\File\File;
use AFUP\HaphpyBirthdayBundle\Form\Type\ContributionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Woecifaun\Bundle\TranslationBridgeBundle\Configuration\TranslationBridge;

/**
 * Default Controller
 */
class DefaultController extends Controller
{
    /**
     * @param Request      $request
     * @param Contribution $contribution
     *
     * @Template()
     * @ParamConverter(converter="public_contribution")
     * @TranslationBridge(placeholders={
     *     "authProvider" = "contribution.authProviderId",
     *     "identifier"   = "contribution.identifier"
     * })
     *
     * @return array for template
     */
    public function contributionAction(Request $request, Contribution $contribution)
    {
        $user = $this->getUser();

        // When getting the page, link file to contribution (for display purpose)
        $this->get('haphpy.file_attacher')->attachFileTo($contribution);

        return [
            'user'         => $user,
            'contribution' => $contribution,
            'gauge'        => $this->get('haphpy.gauge'),
        ];
    }

    /**
     * @param Request $request
     *
     * @Template()
     * @TranslationBridge()
     *
     * @return array for template
     */
    public function indexAction(Request $request)
    {
        $user          = $this->getUser();
        $contributions = $this
            ->get('haphpy.contribution_repository')
            ->findPublicContributionsAlphabetically();

        $userGroups = $this
            ->get('haphpy.pugs')
            ->getUserGroups()
        ;

        return [
            'user'          => $user,
            'contributions' => $contributions,
            'userGroups'    => $userGroups,
            'gauge'         => $this->get('haphpy.gauge'),
        ];
    }

    /**
     * @param Request $request
     *
     * @Template()
     * @TranslationBridge()
     *
     * @return array for template
     */
    public function aboutAction(Request $request)
    {
        $user = $this->getUser();

        return [
            'user' => $user,
            'gauge' => $this->get('haphpy.gauge'),
        ];
    }

    /**
     * In case root path is asked, redirect to best localized home page
     * (Not sure it is the best logical behavior)
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
