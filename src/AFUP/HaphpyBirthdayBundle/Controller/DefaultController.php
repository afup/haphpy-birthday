<?php

namespace AFUP\HaphpyBirthdayBundle\Controller;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\Form\Type\ContributionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Default Controller
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @Template()
     *
     * @return array for template
     */
    public function indexAction(Request $request)
    {
        $user         = $this->getUser();
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

            $this->addFlash(
                'notice',
                'form.notice.submission_success'
            );

            return $this->redirectToRoute('haphpy_index', ['locale' => $request->getLocale()]);
        }

        return [
            'user'  => $user,
            'form'  => $form->createView(),
            'gauge' => $this->get('haphpy.gauge'),
        ];
    }

    /**
     * @param Request $request
     *
     * @Template()
     *
     * @return array for template
     */
    public function contributionsAction(Request $request)
    {
        $user          = $this->getUser();
        $contributions = $this
            ->get('haphpy.contribution_repository')
            ->findPublicContributionsAlphabetically();

        return [
            'user'          => $user,
            'contributions' => $contributions,
            'gauge' => $this->get('haphpy.gauge'),
        ];
    }

    /**
     * @param Request $request
     *
     * @Template()
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
                    'identifier'   => $user->getUsername()
                ]);

            if ($contribution) {
                return $contribution;
            }

            $contribution = new Contribution();
            $contribution->setAuthProvider($user->getAuthProvider());
            $contribution->setIdentifier($user->getUsername());

            return $contribution;
        }

        return new Contribution();
    }
}
