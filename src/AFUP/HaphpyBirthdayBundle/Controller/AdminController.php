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
 *
 * @Route("/admin")
 *
 */
class AdminController extends Controller
{
    /**
     * Admin contribution list
     *
     * @Template()
     * @Route("/", name="haphpy_admin_index")
     *
     * @return []
     */
    public function listAction()
    {
        $user = $this->getUser();

        $contributions = $this
            ->get('haphpy.contribution_repository')
            ->getAllContributions();

        foreach ($contributions as $contribution) {
            $this->get('haphpy.file_attacher')->attachFileTo($contribution);
        }

        return [
            'user'          => $user,
            'contributions' => $contributions,
        ];
    }
}
