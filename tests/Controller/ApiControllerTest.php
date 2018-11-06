<?php

namespace Tests\App\Controller;

use App\Entity\League;
use App\Service\JWTCoder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public $token;

    public function setup()
    {
        $client = static::createClient();

        $this->token = $client->getContainer()->get(JWTCoder::class)->encode([
            'username' => 'user',
        ]);

        // for deleting row
        $league = new League();
        $league->setName('test');

        $em = $client->getContainer()->get('doctrine')->getManager();
        $em->persist($league);
        $em->flush();
    }

    public function testGetTeamFailedWithoutHeader()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('apiGetTeam', ['league' => 'champion']);

        $client->request('GET', $url);

        $response = $client->getResponse();

        $this->assertEquals(401, $response->getStatusCode(), $response->getContent());
    }

    public function testGetTeamSuccess()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('apiGetTeam', ['league' => 'champion']);

        $client->request('GET', $url, [], [], $this->getHeaders());

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('name', $data['0'], $data['0']);
        $this->assertArrayHasKey('strip', $data['0'], $data['0']);

    }

    public function testUpdateTeamSuccess()
    {
        $client = static::createClient();

        $team = $client->getContainer()->get('doctrine')->getRepository('App:Team')->findOneBy(['name' => 'west side team']);

        $url = $client->getContainer()->get('router')->generate('apiUpdateTeam', [
            'id' => $team->getId(),
        ]);

        /** @var League $league */
        $league = $client->getContainer()->get('doctrine')->getRepository('App:League')->findOneBy(['name' => 'tournament']);

        $data = [
            'name' => 'west side team',
            'strip' => 'black 2',
            'league' => $league->getId(),
        ];

        $client->request('PUT', $url, $data, [], $this->getHeaders());

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function testDeleteLeagueSuccess()
    {
        $client = static::createClient();

        $url = $client->getContainer()->get('router')->generate('apiDeleteLeague', [
            'name' => 'test',
        ]);

        $client->request('DELETE', $url, [], [], $this->getHeaders());

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    /**
     * setup headers array with authentication token
     * @return array
     */
    private function getHeaders()
    {
        return [
            'HTTP_AUTHORIZATION' => "Bearer {$this->token}",
            'CONTENT_TYPE' => 'application/json',
        ];
    }
}
