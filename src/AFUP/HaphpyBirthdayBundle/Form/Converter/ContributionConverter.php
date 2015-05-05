<?php

namespace AFUP\HaphpyBirthdayBundle\Form\Converter;

use AFUP\HaphpyBirthdayBundle\Form\Model\Contribution as FormContribution;
use AFUP\HaphpyBirthdayBundle\Model\Contribution as ModelContribution;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class ContributionConverter
{
    public static function getFormContribution(ModelContribution $modelContribution)
    {
        $formContribution = new FormContribution();

        $formContribution->websiteCreditWanted = $modelContribution->isWebsiteCreditWanted();
        $formContribution->videoCreditWanted = $modelContribution->isVideoCreditWanted();

        return $formContribution;
    }

    public static function updateModelFromFormContribution(ModelContribution $modelContribution)
    {
        $formContribution = new FormContribution();

        $formContribution->websiteCreditWanted = $modelContribution->isWebsiteCreditWanted();
        $formContribution->videoCreditWanted = $modelContribution->isVideoCreditWanted();

        
    }
}
