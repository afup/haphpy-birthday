<?php

namespace AFUP\HaphpyBirthdayBundle\Command;

use AFUP\HaphpyBirthdayBundle\Service\ContributionPersister;
use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\Model\UploadedFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
    private $files = [
        'jpg' => '/vagrant/web/assets/images/ilovephp.jpg',
        'mp4' => '/vagrant/web/assets/videos/php-saved-my-life.mp4',
    ];

    /**
     * Credit or not list
     *
     * @var string
     */
    private $credits = ['credited', 'anonymous'];

    /**
     * Moderation list
     *
     * @var string
     */
    private $moderation = ['pending', 'validated', 'rejected'];

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

        foreach ($properties as $tmpContribution) {
            $contribution = new Contribution();
            $contribution->setAuthProvider($tmpContribution['authProvider']);
            $contribution->setIdentifier($tmpContribution['identifier']);
            $contribution->setVisibleName($tmpContribution['identifier']);
            $contribution->setCreditWanted($tmpContribution['creditWanted']);
            $contribution->setFileName($tmpContribution['fileName']);

            $path = $this->files[substr($tmpContribution['fileName'], -3)];

            copy($path, '/var/haphpy/contributions/'.$tmpContribution['fileName']);
            $file = new UploadedFile('/var/haphpy/contributions/'.$tmpContribution['fileName'], 'lol');

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

        $buildArray = function ($identifier, $provider) {
            return [
                'identifier'   => $identifier,
                'authProvider' => $provider,
                'creditWanted' => (bool) array_rand([false, true]),
                'fileName'     => $provider.'/'.$identifier.'.'.array_rand($this->files),
            ];
        };

        foreach ($this->syllables as $syl1) {
            foreach ($this->syllables as $syl2) {
                foreach ($this->syllables as $syl3) {
                    foreach ($this->syllables as $syl4) {
                        foreach ($this->authProviders as $provider) {
                            $identifier = $syl1.$syl2.$syl3.$syl4;
                            $properties[] = $buildArray($identifier, $provider);
                        }
                    }
                }
            }
        }

        return $properties;
    }
}
