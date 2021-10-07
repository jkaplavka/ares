<?php declare(strict_types=1);

namespace Ares\Tests\Service;

use Ares\AresClient;
use Ares\Model\Basic\Activity;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AresBasicServiceTest extends TestCase
{

    public function testBasicServiceApiCorrectResponse(): void
    {
        $httpClient = $this->getMockClientWithResponse(
            new Response(
                200,
                [
                    'Content-Type' => 'text/xml',
                ],
                file_get_contents(__DIR__ . '/../data/basic_correct.xml')
            )
        );
        $aresClient = new AresClient([], $httpClient);
        $entity = $aresClient->basic->findOneByRegNumber('12345678');

        $this->assertSame('12345678', $entity->getRegNumber());
        $this->assertSame('CZ12345678', $entity->getTaxNumber());
        $this->assertSame('Joe Doe', $entity->getName());
        $this->assertSame('1993-04-19', $entity->getDateOfEstablishment()->format('Y-m-d'));
        $this->assertSame(101, $entity->getLegalForm()->getCode());
        $this->assertSame('Fyzická osoba podnikající dle živnostenského zákona', $entity->getLegalForm()->getName());
        $this->assertSame('Česká republika', $entity->getAddress()->getState());
        $this->assertSame('Hustopeče', $entity->getAddress()->getCity());
        $this->assertSame('Střední', $entity->getAddress()->getStreet());
        $this->assertSame('4', $entity->getAddress()->getStreetNumber());
        $this->assertSame('927', $entity->getAddress()->getHouseNumber());
        $this->assertSame('69301', $entity->getAddress()->getPostalCode());
        $this->assertSame('Neuvedeno', $entity->getEmployes());
        $this->assertCount(3, $entity->getActivities()->getList());
        $this->assertObjectEquals(
            new Activity('Z01038', 'Výroba, opravy a údržba sportovních potřeb, her, hraček a dětských kočárků'),
            $entity->getActivities()->getList()[0]
        );
        $this->assertObjectEquals(
            new Activity('Z01047', 'Zprostředkování obchodu a služeb'),
            $entity->getActivities()->getList()[1]
        );
        $this->assertObjectEquals(
            new Activity('Z01048', 'Velkoobchod a maloobchod'),
            $entity->getActivities()->getList()[2]
        );
    }

    public function testBasicServiceApiNotFound(): void
    {
        $httpClient = $this->getMockClientWithResponse(
            new Response(
                200,
                [
                    'Content-Type' => 'text/xml',
                ],
                file_get_contents(__DIR__ . '/../data/basic_not_found.xml')
            )
        );

        $this->expectException(\Ares\Exception\EntityNotFoundException::class);

        $aresClient = new AresClient([], $httpClient);
        $aresClient->basic->findOneByRegNumber('12345678');
    }

    public function testBasicServiceApiInternalError(): void
    {
        $httpClient = $this->getMockClientWithResponse(
            new Response(500, [])
        );

        $this->expectException(\Ares\Exception\ServiceUnavailableException::class);

        $aresClient = new AresClient([], $httpClient);
        $aresClient->basic->findOneByRegNumber('12345678');
    }

    public function testBasicServiceApiEmptyResponse(): void
    {
        $httpClient = $this->getMockClientWithResponse(
            new Response(200, [])
        );

        $this->expectException(\Ares\Exception\ServiceUnavailableException::class);

        $aresClient = new AresClient([], $httpClient);
        $aresClient->basic->findOneByRegNumber('12345678');
    }

    public function testBasicServiceApiCorruptedResponse(): void
    {
        $httpClient = $this->getMockClientWithResponse(
            new Response(
                200,
                [
                    'Content-Type' => 'text/xml',
                ],
                '<?xml version="1.0" ...'
            )
        );

        $this->expectException(\Ares\Exception\ServiceUnavailableException::class);

        $aresClient = new AresClient([], $httpClient);
        $aresClient->basic->findOneByRegNumber('12345678');
    }

    /**
     * Creates mock client with fake API response(s)
     *
     * @param \GuzzleHttp\Psr7\Response ...$responses
     *
     * @return \GuzzleHttp\Client
     */
    private function getMockClientWithResponse(Response ...$responses): Client
    {
        $mockResponseHandler = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mockResponseHandler);

        return new Client(['handler' => $handlerStack]);
    }

}
