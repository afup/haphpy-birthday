<?php

namespace AFUP\HaphpyBirthdayBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateContributionsCommand extends Command
{
    /**
     * Folder containing users contributions
     *
     * @var string
     */
    private $contributionsRootDir;

    /**
     * Unit block for name building
     *
     * @var string[]
     */
    private $syllables = [
        'ma',
        'te',
        'bi',
        'ko',
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
     * @param string $contributionsRootDir
     */
    public function __construct($contributionsRootDir)
    {
        parent::__construct();

        $this->contributionsRootDir = $contributionsRootDir;
    }

    protected function configure()
    {
        $this
            ->setName('haphpy:contributions:generate')
            ->setDescription('Generate Fake Contributions for dev env')
            ->addArgument(
                'quantity',
                InputArgument::OPTIONAL,
                'How many fake contributions do you want to generate?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $quantity = $input->getArgument('quantity') ? : 100;
        $names = $this->generateNames();

        if ($quantity) {
            shuffle($names);
            $names = array_slice($names, 0, $quantity);
        }

        foreach ($names as $name) {
            fopen($name, 'w');
            $output->writeln($this->contributionsRootDir." : ".$quantity." : ".$name);
        }
    }

    private function generateNames()
    {
        $names = [];

        foreach ($this->syllables as $syl1) {
            foreach ($this->syllables as $syl2) {
                foreach ($this->syllables as $syl3) {
                    foreach ($this->syllables as $syl4) {
                        foreach ($this->authProviders as $provider) {
                            $names[] =
                                $this->contributionsRootDir.'/'
                                .$syl1.$syl2.$syl3.$syl4
                                .'@'.$provider
                                .'-'.$this->credits[array_rand($this->credits)]
                                .'-'.$this->moderation[array_rand($this->moderation)]
                                .'.'.$this->extensions[array_rand($this->extensions)]
                            ;
                        }
                    }
                }
            }
        }

        return $names;
    }

    public function cleanDirectory($directory)
    {
        $files = glob('path/to/temp/*');
        foreach($files as $file){
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
