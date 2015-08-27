<?php

namespace AFUP\HaphpyBirthdayBundle\Tests\Service;

use AFUP\HaphpyBirthdayBundle\Entity\Contribution;
use AFUP\HaphpyBirthdayBundle\Service\FileAttacher;
use AFUP\HaphpyBirthdayBundle\Service\PathGenerator;

/**
 * File attacher test
 *
 * @author Faun <woecifaun@gmail.com>
 */
class FileAttacherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PathGenerator
     */
    protected $pathGenerator;

    /**
     * @var Contribution
     */
    protected $contribution;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contribution = (new Contribution())
            ->setAuthProvider('github')
            ->setIdentifier('woecifaun');

        $this->pathGenerator = $this->getMockBuilder('AFUP\HaphpyBirthdayBundle\Service\PathGenerator')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        // Attacher just need a file (any file) to attach to contribution
        // The only one file to be sure to exist, is this file itself :p
        $this->pathGenerator->method('getFileAbsolutePath')
            ->willReturn(__FILE__);
    }

    /**
     * Test that file is attached to the contribution
     */
    public function testAttachFileTo()
    {
        $fileAttacher  = new FileAttacher($this->pathGenerator);

        $this->assertFalse($fileAttacher->attachFileTo($this->contribution));

        $this->contribution->setFileName('not_an_empty_name.jpg');
        $fileAttacher->attachFileTo($this->contribution);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\File\File', $this->contribution->getFile());
    }
}
