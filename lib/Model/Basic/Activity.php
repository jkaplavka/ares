<?php declare(strict_types=1);

namespace Ares\Model\Basic;

use JMS\Serializer\Annotation as JMS;

/**
 * Business activity of entity
 */
class Activity
{

    /**
     * @JMS\SerializedName("D:K")
     *
     * @var string|null
     */
    private ?string $code = null;

    /**
     * @JMS\SerializedName("D:T")
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * Retuns code of business activity
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Retuns name of business activity
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

}
