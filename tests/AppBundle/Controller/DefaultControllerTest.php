<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        /*echo $crawler->html();
        
        $response = $client->getResponse();
        
        if (!$response->isSuccessful()) {     $block = $crawler->filter('div.text-exception > h1');     if ($block->count()) {         $error = $block->text();     } }*/

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
}
