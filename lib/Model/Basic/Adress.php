<?php declare(strict_types=1);

namespace Ares\Model\Basic;

use JMS\Serializer\Annotation as JMS;

/**
 * Adress of business entity
 */
class Adress
{

    /**
     * @JMS\SerializedName("D:NS")
     *
     * @var string|null
     */
    private ?string $state = null;

    /**
     * @JMS\SerializedName("D:N")
     *
     * @var string|null
     */
    private ?string $city = null;

    /**
     * @JMS\SerializedName("D:NU")
     *
     * @var string|null
     */
    private ?string $street = null;

    /**
     * @JMS\SerializedName("D:CO")
     *
     * @var string|null
     */
    private ?string $streetNumber = null;

    /**
     * @JMS\SerializedName("D:CD")
     *
     * @var string|null
     */
    private ?string $houseNumber = null;

    /**
     * @JMS\SerializedName("D:PSC")
     *
     * @var string|null
     */
    private ?string $postalCode = null;

    /**
     * Get the value of state
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Get the value of city
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Get the value of street
     *
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Get the value of streetNumber
     *
     * @return string|null
     */
    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    /**
     * Get the value of houseNumber
     *
     * @return string|null
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * Get the value of postalCode
     *
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

}
