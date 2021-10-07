<?php declare(strict_types=1);

namespace Ares\Tests;

use Ares\AresClient;
use PHPUnit\Framework\TestCase;

final class AresClientTest extends TestCase
{

    public function testConfigExtraParameter(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        new AresClient(['http_errors' => false]);
    }

    public function testConfigTimeoutWrongType(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        new AresClient(['timeout' => '5']);
    }

    public function testConfigTimeoutOutOfRange(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        new AresClient(['timeout' => -1]);
    }

    public function testRegNumberInvalid(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        $aresClient = new AresClient();
        $aresClient->basic->findOneByRegNumber('SK123456');
    }

    public function testRegNumberShort(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        $aresClient = new AresClient();
        $aresClient->basic->findOneByRegNumber('123456');
    }

    public function testRegNumberLong(): void
    {
        $this->expectException(\Ares\Exception\InvalidArgumentException::class);

        $aresClient = new AresClient();
        $aresClient->basic->findOneByRegNumber('123456789');
    }

}
