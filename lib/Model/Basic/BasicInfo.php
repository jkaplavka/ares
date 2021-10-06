<?php declare(strict_types=1);

namespace Ares\Model\Basic;

use DateTimeImmutable;
use JMS\Serializer\Annotation as JMS;

/**
 * Basic informations about business entity
 */
class BasicInfo
{

    /**
     * @JMS\SerializedName("D:ICO")
     *
     * @var string
     */
    private string $regNumber;

    /**
     * @JMS\SerializedName("D:DIC")
     *
     * @var string|null
     */
    private ?string $taxNumber = null;

    /**
     * @JMS\SerializedName("D:OF")
     *
     * @var string
     */
    private string $name;

    /**
     * @JMS\SerializedName("D:DV")
     * @JMS\Type("DateTimeImmutable<'Y-m-d', 'UTC'>")
     *
     * @var \DateTimeImmutable|null
     */
    private ?DateTimeImmutable $dateOfEstablishment;

    /**
     * @JMS\SerializedName("D:PF")
     * @JMS\Type(LegalForm::class)
     *
     * @var \Ares\Model\Basic\LegalForm|null
     */
    private ?LegalForm $legalForm;

    /**
     * @JMS\SerializedName("D:AA")
     * @JMS\Type(Adress::class)
     *
     * @var \Ares\Model\Basic\Adress|null
     */
    private ?Adress $address;

    /**
     * @JMS\SerializedName("D:KPP")
     *
     * @var string|null
     */
    private ?string $employes;

    /**
     * @JMS\SerializedName("D:Obory_cinnosti")
     * @JMS\Type(Activities::class)
     *
     * @var \Ares\Model\Basic\Activities|null
     */
    private ?Activities $activities;

    /**
     * Returns registration number of business entity
     *
     * @return string
     */
    public function getRegNumber(): string
    {
        return $this->regNumber;
    }

    /**
     * Returns tax number of business entity
     *
     * @return ?string
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * Returns name of business entity
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns date of registration of business entity
     *
     * @return ?\DateTimeImmutable
     */
    public function getDateOfEstablishment(): ?DateTimeImmutable
    {
        return $this->dateOfEstablishment->setTime(0, 0, 0);
    }

    /**
     * Returns legal form of business entity
     *
     * @return ?\Ares\Model\Basic\LegalForm
     */
    public function getLegalForm(): ?LegalForm
    {
        return $this->legalForm;
    }

    /**
     * Returns adress of business entity
     *
     * @return ?\Ares\Model\Basic\Adress
     */
    public function getAddress(): ?Adress
    {
        return $this->address;
    }

    /**
     * Returns range number of employes in business entity
     *
     * @return ?string
     */
    public function getEmployes(): ?string
    {
        return $this->employes;
    }

    /**
     * Returns business activities of entity
     *
     * @return ?\Ares\Model\Basic\Activities
     */
    public function getActivities(): ?Activities
    {
        return $this->activities;
    }

}
