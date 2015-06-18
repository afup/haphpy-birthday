<?php

namespace AFUP\HaphpyBirthdayBundle\Model;

use AFUP\HaphpyBirthdayBundle\Entity\ContributionRepository;

/**
 * User
 *
 * @author Faun <woecifaun@gmail.com>
 */
class Gauge
{
    /**
     * Symbolic steps the Progress can reach
     *
     * @var array
     */
    private $steps = [];

    /**
     * The number of Contributions
     *
     * @var int
     */
    private $amount;

    /**
     * Maximum of the Gauge
     *
     * @var int
     */
    private $maximum;

    /**
     * Construct
     *
     * @param ContributionRepository $contributionRepository
     * @param array                  $steps
     */
    public function __construct(ContributionRepository $contributionRepository, $steps)
    {
        $this->amount  = $contributionRepository->getContributionsQuantity();
        $this->steps   = $steps;
    }

    /**
     * Get steps
     *
     * @return array
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Get Contributions quantity
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get contributions in percent
     * relative to the step max value
     *
     * @return int
     */
    public function getPercent()
    {
        return round(($this->amount / $this->getStepsMaxValue()) * 100);
    }

    /**
     * Find the maximum value in the provided steps
     *
     * @return int
     */
    public function getStepsMaxValue()
    {
        if ($this->maximum === null) {
            $values = [];

            foreach ($this->steps as $step) {
                $values[] = $step['value'];
            }

            $this->maximum = max($values);
        }

        return $this->maximum;
    }
}
