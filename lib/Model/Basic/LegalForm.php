<?php declare(strict_types=1);

namespace Ares\Model\Basic;

use JMS\Serializer\Annotation as JMS;

/**
 * Legal form of business entity
 */
class LegalForm
{

    /**
     * @JMS\SerializedName("D:KPF")
     *
     * @var int|null
     */
    private ?int $code = null;

    /**
     * @JMS\SerializedName("D:NPF")
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * Returns code of legal form
     *
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * Returns name of legal form
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

}
