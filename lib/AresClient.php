<?php declare(strict_types=1);

namespace Ares;

use Ares\Model\Common\Response;
use Ares\Model\Common\ResponseMeta;
use Ares\Service\BasicService;
use GuzzleHttp;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Webmozart\Assert\Assert;

/**
 * Client class allows a retrieval of informations about business entities
 * registered in the Czech Republic.
 *
 * @see https://wwwinfo.mfcr.cz/ares//ares.html.en
 */
class AresClient
{

    private const API_URL = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/';
    private const DEFAULT_CONFIG = [
        'timeout' => 10,
    ];

    private GuzzleHttp\Client $httpClient;
    private Serializer $serializer;

    /**
     * The Basic service displays basic information selected from more source registers.
     * The basic data (Reg.No., Business name, Legal form, Address) comes from the ARES core,
     * i.e. from one of the sources defined as a priority source for the entity.
     * The entity's Date of establishment and Date of termination come also from the priority source.
     * Some elements contain information on the source from which the data comes.
     *
     * @var \Ares\Service\BasicService
     */
    public BasicService $basic;

    /**
     * Initializes new instance of client instance responsible for comunicating with API.
     *
     * Available configuration settings:
     * - **timeout** (int) number of seconds greater or equal than zero
     *
     * @param array<string, mixed> $config array with configuration settings
     *
     * @throws \Webmozart\Assert\InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $config = array_merge(static::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->serializer = SerializerBuilder::create()->build();
        $this->httpClient = new GuzzleHttp\Client(
            array_merge(
                [
                    'base_uri' => static::API_URL,
                ],
                $config
            )
        );

        $this->basic = new BasicService($this);
    }

    /**
     * Makes request to ARES API endpoint specifiend in argument
     * using GuzzleHttp\Client and returns single response object.
     *
     * @param string $method valid HTTP method (GET, POST, ...)
     * @param string $endpoint ARES API endpoint @see https://wwwinfo.mfcr.cz/ares//ares_xml.html.en#k3
     * @param array<string, mixed> $options @see https://docs.guzzlephp.org/en/stable/request-options.html
     *
     * @return \Ares\Model\Common\Response
     *
     * @throws \Ares\Exception\ServiceUnavailableException
     */
    public function request(
        string $method,
        string $endpoint = '',
        array $options = []
    ): Response
    {
        try {
            $responseRaw = $this->httpClient->request($method, $endpoint, $options);
            $responseMeta = $this->deserializeXMLResponse($responseRaw->getBody()->__toString());
            $firstResponse = $responseMeta->getFirstResponse();

            if ($firstResponse === null) {
                throw new \Ares\Exception\ServiceUnavailableException('Invalid response, no entity or error returned.');
            }

            return $firstResponse;
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            throw new \Ares\Exception\ServiceUnavailableException($e->getMessage());
        }
    }

    /**
     * Deserializes raw XML API response to PHP object,
     * in case of malformed API response throws ServiceUnavailableException.
     *
     * @param string $xmlData raw XML API response
     *
     * @return \Ares\Model\Common\ResponseMeta
     *
     * @throws \Ares\Exception\ServiceUnavailableException
     */
    private function deserializeXMLResponse(string $xmlData): ResponseMeta
    {
        try {
            $responseMeta = $this->serializer->deserialize($xmlData, ResponseMeta::class, 'xml');

            return $responseMeta;
        } catch (\JMS\Serializer\Exception\Exception $e) {
            throw new \Ares\Exception\ServiceUnavailableException('Invalid API response: ' . $e->getMessage());
        }
    }

    /**
     * Validates config overrides passed to constructor
     *
     * @param array<string, mixed> $config
     *
     * @throws \Ares\Exception\InvalidArgumentException
     */
    private function validateConfig(array $config): void
    {
        try {
            // Check presence of extra config parameters
            $extraParameters = array_diff_key($config, static::DEFAULT_CONFIG);
            Assert::count(
                $extraParameters,
                0,
                sprintf('Found extra config parameter(s). Got: %s', implode(',', array_keys($extraParameters)))
            );

            // Timeout assertions
            Assert::integer($config['timeout'], 'Timeout config parameter must be an integer. Got: %s');
            Assert::greaterThanEq(
                $config['timeout'],
                0,
                'Timeout config parameter must be greater or queal than 0. Got: %s'
            );
        } catch (\Webmozart\Assert\InvalidArgumentException $exception) {
            throw new \Ares\Exception\InvalidArgumentException($exception->getMessage());
        }
    }

}
