<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\HttpFoundation\File\File;
use AFUP\HaphpyBirthdayBundle\Form\Type\ContributionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @param Request $request
     *
     * @Template()
     * @TranslationBridge()
     *
     * @return array for template
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        // if limit date is over, we don't handle form
        $limitDate = new \DateTime($this->container->getParameter('limit_date'));
        if ($limitDate < (new \DateTime())) {
            return [
                'user'  => $user,
                'gauge' => $this->get('haphpy.gauge'),
            ];
        }

        // Otherwise we go with the form
        $contribution = $this->getOrGenerateContribution($user);

        $formContribution = $this->get('haphpy.form.contribution_converter')
            ->getFormContribution($contribution);

        $form = $this->createForm(new ContributionType(), $formContribution);
        $form->handleRequest($request);

        if ($user && $form->isValid()) {
            $this->get('haphpy.form.contribution_converter')
                ->updateEntityFromFormContribution($contribution, $formContribution);
            $this->get('haphpy.contribution_persister')
                ->persist($contribution, $formContribution->file);

            $this->addFlash('submission-success', true);

            return $this->redirectToRoute('haphpy_submitted', ['locale' => $request->getLocale()]);
        }

        // When getting the page, link file to contribution (for display purpose)
        $this->get('haphpy.file_attacher')->attachTo($contribution);

        return [
            'user'         => $user,
            'form'         => $form->createView(),
            'gauge'        => $this->get('haphpy.gauge'),
            'contribution' => $contribution,
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
    public function submittedAction(Request $request)
    {
        $success = $this->container->get('session')->getFlashBag()->get('submission-success');

        if (!$success) {
            return $this->redirectToRoute('haphpy_index', ['locale' => $request->getLocale()]);
        }

        $user         = $this->getUser();
        $contribution = $this->getOrGenerateContribution($user);

        return [
            'user'         => $user,
            'contribution' => $contribution,
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $user         = $this->getUser();
        $contribution = $this->getOrGenerateContribution($user);

        if ($contribution->getFileName()) {
            $this->get('haphpy.contribution_persister')->remove($contribution);
        }

        return $this->redirectToRoute('haphpy_index', ['locale' => $request->getLocale()]);
    }

    /**
     * @param Request $request
     *
     * @Template()
     * @TranslationBridge()
     *
     * @return array for template
     */
    public function contributionsAction(Request $request)
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

    /**
     * get a contribution depending on user
     * If none yet, create one
     *
     * @param UserInterface $user Current user
     *
     * @return Contribution
     */
    private function getOrGenerateContribution(UserInterface $user = null)
    {
        if ($user) {
            $contribution = $this
                ->getDoctrine()
                ->getEntityManager()
                ->getRepository('AFUP\HaphpyBirthdayBundle\Entity\Contribution')
                ->findOneBy([
                    'authProvider' => $user->getAuthProvider(),
                    'identifier'   => $user->getUsername(),
                ]);

            if ($contribution) {
                return $contribution;
            }

            $contribution = new Contribution();
            $contribution->setAuthProvider($user->getAuthProvider());
            $contribution->setIdentifier($user->getUsername());
            $contribution->setVisibleName($user->getVisibleName());

            return $contribution;
        }

        return new Contribution();
    }
}
