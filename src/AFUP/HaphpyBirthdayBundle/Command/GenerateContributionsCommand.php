<?php

namespace AFUP\HaphpyBirthdayBundle\Command;

use AFUP\HaphpyBirthdayBundle\Service\ContributionPersister;
use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Generate fake contribution entities and media
 *
 * @author Faun <woecifaun@gmail.com>
 */
class GenerateContributionsCommand extends Command
{
    /**
     * Contribution Persister
     *
     * @var ContributionPersister
     */
    private $contributionPersister;

    /**
     * Unit block for name building
     *
     * @var string[]
     */
    private $syllables = [
        'ma',
        'te',
        'ko',
        'pi',
    ];

    /**
     * Provider list
     *
     * @var string
     */
    private $authProviders = [
        'github',
        'twitter',
        'facebook',
    ];

    /**
     * Extension list
     *
     * @var string
     */
    private $extensions = [
        'jpg',
        'jpeg',
        'mp4',
        'mov',
    ];

    /**
     * Credit or not list
     *
     * @var string
     */
    private $credits = ['credited','anonymous'];

    /**
     * Moderation list
     *
     * @var string
     */
    private $moderation = ['pending','validated','rejected'];

    /**
     * Construct
     *
     * @param ContributionPersister $contributionPersister
     */
    public function __construct(ContributionPersister $contributionPersister)
    {
        parent::__construct();

        $this->contributionPersister = $contributionPersister;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('haphpy:contributions:generate')
            ->setDescription('Generate Fake Contributions for dev env')
            ->addArgument(
                'quantity',
                InputArgument::OPTIONAL,
                'How many fake contributions do you want to generate?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $quantity = $input->getArgument('quantity') ? : 100;
        $properties = $this->generateProperties();

        if ($quantity) {
            shuffle($properties);
            $properties = array_slice($properties, 0, $quantity);
        }

        $path = '/var/haphpy/contributions/fake.jpg';

        foreach ($properties as $tmpContribution) {
            $contribution = new Contribution();
            $contribution->setAuthProvider($tmpContribution['authProvider']);
            $contribution->setIdentifier($tmpContribution['identifier']);
            $contribution->setCreditWanted($tmpContribution['creditWanted']);

            fopen($path, 'w');
            $file = new File($path);

            $this->contributionPersister->persist($contribution, $file);
        }
    }

    /**
     * Generate properties ready to be set on Contributions
     *
     * @return array already formatted properties
     */
    private function generateProperties()
    {
        $properties = [];

        foreach ($this->syllables as $syl1) {
            foreach ($this->syllables as $syl2) {
                foreach ($this->syllables as $syl3) {
                    foreach ($this->syllables as $syl4) {
                        foreach ($this->authProviders as $provider) {
                            $properties[] = [
                                'identifier'   => $syl1.$syl2.$syl3.$syl4,
                                'authProvider' => $provider,
                                'creditWanted' => array_rand([true, false])
                            ]
                            ;
                        }
                    }
                }
            }
        }

        return $properties;
    }
}
