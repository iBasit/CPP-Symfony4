<?php

namespace Tests\App\Controller;

use App\Service\JWTCoder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testloginSuccess()
    {
        $client = static::createClient();

        $client->request('POST', '/login', [
            'username' => 'user',
            'password' => 'userpass',
        ]);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function testloginFailed()
    {
        $client = static::createClient();

        $client->request('POST', '/login', [
            'username' => 'user',
            'password' => '23sdf',
        ]);

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode(), $response->getContent());
    }

    public function testloginFailedWithNoData()
    {
        $client = static::createClient();

        $client->request('POST', '/login');

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode(), $response->getContent());
    }
}
