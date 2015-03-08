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
        $locales = [
            'fr' => 'Bonjour',
            'en' => 'Hi',
        ];

        foreach ($locales as $locale => $translation) {
            $crawler = $client->request('GET', "/$locale/");

            $this->assertTrue(
                $crawler->filter('html:contains("'.$translation.'")')->count() > 0
            );
        }
    }
}
