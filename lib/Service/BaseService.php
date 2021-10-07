<?php declare(strict_types=1);

namespace Ares\Service;

use Ares\AresClient;
use Webmozart\Assert\Assert;

abstract class BaseService
{

    protected AresClient $client;

    public function __construct(AresClient $client)
    {
        $this->client = $client;
    }

    abstract protected function getServiceEndpoint(): string;

    /**
     * Cleans up registration number into desired format
     *
     * - removes all whitespaces
     *
     * @param string $regNumber
     *
     * @return string
     */
    protected function cleanUpRegNumber(string $regNumber): string
    {
        return str_replace(' ', '', $regNumber);
    }

    /**
     * Validates registration number
     *
     * - contains 8 digits
     *
     * @param string $regNumber
     *
     * @throws \Ares\Exception\InvalidArgumentException
     */
    protected function validateRegNumber(string $regNumber): void
    {
        try {
            Assert::digits($regNumber, 'Registration number parameter must cointains only digits. Got: %s');
            Assert::length($regNumber, 8, 'Registration number parameter must cointains 8 characters. Got: %s');
        } catch (\Webmozart\Assert\InvalidArgumentException $exception) {
            throw new \Ares\Exception\InvalidArgumentException($exception->getMessage());
        }
    }

}
