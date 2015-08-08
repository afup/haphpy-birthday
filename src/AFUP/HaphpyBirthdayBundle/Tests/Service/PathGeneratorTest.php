<?php

namespace AFUP\HaphpyBirthdayBundle\Tests\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\Service\PathGenerator;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Path generator test
 *
 * @author Faun <woecifaun@gmail.com>
 */
class PathGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * contribution directory path
     *
     * @var string
     */
    protected $directory = '/contributions';

    /**
     * @var Contribution
     */
    protected $contribution;

    /**
     * extension that should be returne by the file
     *
     * @var string
     */
    protected $extension = 'jpg';

    /**
     * @var File
     */
    protected $file;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contribution = (new Contribution())->setAuthProvider('github')
            ->setIdentifier('woecifaun')
            ->setFileName('github/woecifaun.jpg');

        $this->file = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\File')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->file->method('guessExtension')
            ->willReturn($this->extension);
    }

    /**
     * Test if path for an uploaded contribution file is ok
     */
    public function testGetFileAbsolutePath()
    {
        $pathGenerator = new PathGenerator($this->directory);

        $fileName = 'github/woecifaun.jpg';
        $this->contribution->setFileName($fileName);

        $absolutePath = $pathGenerator->getFileAbsolutePath($this->contribution);
        $this->assertEquals($absolutePath, $this->directory.DIRECTORY_SEPARATOR.$fileName);
    }

    /**
     * Test if generated absolute path for new contribution is ok
     */
    public function testGenerateAbsolutePath()
    {
        $pathGenerator = new PathGenerator($this->directory);

        $path  = $this->directory.DIRECTORY_SEPARATOR;
        $path .= $this->contribution->getAuthProvider().DIRECTORY_SEPARATOR;
        $path .= $this->contribution->getIdentifier();
        $path .= '.'.$this->extension;

        $absolutePath = $pathGenerator->generateAbsolutePath($this->contribution, $this->file);
        $this->assertEquals(
            $absolutePath,
            $path
        );
    }

    /**
     * Test if generated relative path for new contribution is ok
     */
    public function testGenerateRelativePath()
    {
        $pathGenerator = new PathGenerator($this->directory);

        $path  = $this->contribution->getAuthProvider().DIRECTORY_SEPARATOR;
        $path .= $this->contribution->getIdentifier();
        $path .= '.'.$this->extension;

        $relativePath = $pathGenerator->generateRelativePath($this->contribution, $this->file);
        $this->assertEquals(
            $relativePath,
            $path
        );
    }
}
