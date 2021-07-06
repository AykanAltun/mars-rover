<?php
declare(strict_types=1);

namespace App\Tests\Controller\v1;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlateauControllerTest extends WebTestCase
{
    const CREATE_PLATEAU_URL = 'http://localhost/api/v1/plateau';
    const GET_PLATEAU_URL = 'http://localhost/api/v1/plateau/{id}';
    const PLATEAU_ID = '1c028f0748c48f06551ac330c95ad844';

    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    /**
     * @dataProvider \App\DataProvider\PlateauDataProvider::providePlateauRequest()
     * @param $plateauRequest
     */
    #[NoReturn]
    public function testCreateSuccess($plateauRequest): void
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: self::CREATE_PLATEAU_URL,
            content: json_encode($plateauRequest)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Statü kodu 200 değildir.');
    }

    #[NoReturn]
    public function testGetSuccess(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            str_replace('{id}', self::PLATEAU_ID, self::GET_PLATEAU_URL)
        );
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Statü kodu 200 değildir.');
        $content = json_decode($response->getContent(), true);
        $this->assertNotEmpty($content, 'Response boş geldi.');
        $this->assertArrayHasKey('id', $content, 'Response içerisinde id gelmedi.');
        $this->assertArrayHasKey('name', $content, 'Response içerisinde name gelmedi.');
        $this->assertArrayHasKey('status', $content, 'Response içerisinde status gelmedi.');
    }
}
