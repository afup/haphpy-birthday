<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use AFUP\HaphpyBirthdayBundle\Form\Type\ContributionType;
use AFUP\HaphpyBirthdayBundle\Model\Contribution;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction(Request $request)
    {
        $user  = $this->getUser();
        $contribution = new Contribution();
        if ($user) {
            $contribution->setAuthProvider($user->getResourceOwner());
            $contribution->setIdentifier($user->getUsername());
        }

        $formContribution = $this->get('haphpy.form.contribution_converter')->getFormContribution($contribution);


        $form = $this->createForm(new ContributionType(), $formContribution);

        $form->handleRequest($request);

        if ($user && $form->isValid()) {
            // perform some action, such as saving the task to the database

            dump($formContribution);die;
        }

        return [
            'user' => $user,
            'form' => $form->createView(),
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
