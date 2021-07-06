<?php
declare(strict_types=1);

namespace App\Tests\Controller\v1;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoverControllerTest extends WebTestCase
{
    const CREATE_ROVER_URL = 'http://localhost/api/v1/rover';
    const GET_ROVER_URL = 'http://localhost/api/v1/rover/{id}';
    const GET_ROVER_STATE_URL = 'http://localhost/api/v1/rover/{id}/state';
    const SEND_ROVER_COMMANDS_URL = 'http://localhost/api/v1/rover/{id}/send-commands';
    const ROVER_ID = '67ebfed1cb54f380c99d3b4073cfc780';

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    /**
     * @dataProvider \App\DataProvider\RoverDataProvider::provideRoverRequest()
     * @param $roverRequest
     */
    #[NoReturn]
    public function testCreateSuccess($roverRequest): void
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: self::CREATE_ROVER_URL,
            content:  json_encode($roverRequest)
        );
        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode(),
            'Statü kodu 200 değildir.'
        );
    }

    #[NoReturn]
    public function testGetSuccess(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            str_replace('{id}', self::ROVER_ID, self::GET_ROVER_URL)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Statü kodu 200 değildir.');
        $content = json_decode($response->getContent(), true);
        $this->assertNotEmpty($content, 'Response boş geldi.');
        $this->assertArrayHasKey('id', $content, 'Response içerisinde id gelmedi.');
        $this->assertArrayHasKey('name', $content, 'Response içerisinde name gelmedi.');
        $this->assertArrayHasKey('status', $content, 'Response içerisinde status gelmedi.');
        $this->assertArrayHasKey('plateau', $content, 'Response içerisinde plateau gelmedi.');
        $this->assertArrayHasKey('xCoordinate', $content, 'Response içerisinde xCoordinate gelmedi.');
        $this->assertArrayHasKey('yCoordinate', $content, 'Response içerisinde yCoordinate gelmedi.');
        $this->assertArrayHasKey('direction', $content, 'Response içerisinde direction gelmedi.');
    }

    #[NoReturn]
    public function testGetStateSuccess(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            str_replace('{id}', self::ROVER_ID, self::GET_ROVER_STATE_URL)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Statü kodu 200 değildir.');
        $content = json_decode($response->getContent(), true);
        $this->assertNotEmpty($content, 'Response boş geldi.');
        $this->assertArrayHasKey('state', $content, 'Response içerisinde state gelmedi.');
    }

    /**
     * @dataProvider \App\DataProvider\SendCommandsDataProvider::provideSendCommandsRequest()
     * @param $sendCommandsRequest
     */
    #[NoReturn]
    public function testSendCommandsSuccess($sendCommandsRequest): void
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: str_replace('{id}', self::ROVER_ID, self::SEND_ROVER_COMMANDS_URL),
            content: json_encode($sendCommandsRequest)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Statü kodu 200 değildir.');
    }
}
