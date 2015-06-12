<?php

namespace AFUP\HaphpyBirthdayBundle\Form\Converter;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution as EntityContribution;
use AFUP\HaphpyBirthdayBundle\Form\Model\Contribution as FormContribution;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class ContributionConverter
{
    /**
     * Create a Contribution instance for form handling
     *
     * @param EntityContribution $entityContribution
     *
     * @return FormContribution [description]
     */
    public static function getFormContribution(EntityContribution $entityContribution)
    {
        $formContribution = new FormContribution();

        $formContribution->websiteCreditWanted = $entityContribution->isWebsiteCreditWanted();
        $formContribution->videoCreditWanted   = $entityContribution->isVideoCreditWanted();

        return $formContribution;
    }

    /**
     * Update the EntityContribution depending on FormContribution
     *
     * @param EntityContribution $entityContribution
     * @param FormContribution   $formContribution
     */
    public static function updateEntityFromFormContribution(
        EntityContribution $entityContribution,
        FormContribution   $formContribution
    ) {
        $entityContribution->setWebsiteCreditWanted($formContribution->websiteCreditWanted);
        $entityContribution->setVideoCreditWanted($formContribution->videoCreditWanted);
    }
}
