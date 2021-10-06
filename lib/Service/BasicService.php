<?php declare(strict_types=1);

namespace Ares\Service;

use Ares\AresClient;
use Ares\Model\Basic\BasicInfo;

/**
 * The Basic service displays basic information selected from more source registers.
 * The basic data (Reg.No., Business name, Legal form, Address) comes from the ARES core,
 * i.e. from one of the sources defined as a priority source for the entity.
 * The entity's Date of establishment and Date of termination come also from the priority source.
 * Some elements contain information on the source from which the data comes.
 */
class BasicService extends BaseService
{

    public function __construct(AresClient $client)
    {
        parent::__construct($client);
    }

    protected function getServiceEndpoint(): string
    {
        return 'darv_bas.cgi';
    }

    /**
     * Retrieves single business entity by registration number (ICO)
     *
     * @param string $regNumber registration number (ICO)
     *
     * @return \Ares\Model\Basic\BasicInfo
     *
     * @throws \Ares\Exception\InvalidArgumentException
     * @throws \Ares\Exception\ServiceUnavailableException
     * @throws \Ares\Exception\EntityNotFoundException
     */
    public function findOneByRegNumber(string $regNumber): BasicInfo
    {
        $regNumber = $this->cleanUpRegNumber($regNumber);
        $this->validateRegNumber($regNumber);

        $response = $this->client->request('GET', $this->getServiceEndpoint(), [
            'query' => [
                'ico' => $regNumber,
            ],
        ]);

        if ($response->isError()) {
            if ($response->getError()->isNotFoundError()) {
                throw new \Ares\Exception\EntityNotFoundException('Business entity was not found.');
            }

            throw new \Ares\Exception\ServiceUnavailableException($response->getError()->getMessage());
        }

        return $response->getBasicInfo();
    }

}
