<?php

namespace AFUP\HaphpyBirthdayBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * {@inheritdoc}
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Check that no localized homepage request is redirected
     */
    public function testRedirection()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertTrue($response->getStatusCode() == 302);
    }

    /**
     * Test localized index page
     */
    public function testIndex()
    {
        $client = static::createClient();
        $locales = ['fr', 'en'];

        foreach ($locales as $locale) {
            $crawler = $client->request('GET', "/$locale/");

            $navbarLogo = $crawler->filter('a.navbar-logo')->first()->text();
            $this->assertEquals($navbarLogo, 'HaPHPy Birthday');
        }
    }
}
