<?php declare(strict_types=1);

namespace Ares\Model\Common;

use JMS\Serializer\Annotation as JMS;

class ResponseError
{

    private const NOT_FOUND = 'Chyba 71';

    /**
     * @JMS\SerializedName("D:EK")
     *
     * @var string|null
     */
    private ?string $code = null;

    /**
     * @JMS\SerializedName("D:ET")
     *
     * @var string|null
     */
    private ?string $message = null;

    /**
     * Returns error code
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Returns error message
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function isNotFoundError(): bool
    {
        if ($this->message !== null && str_contains($this->message, static::NOT_FOUND)) {
            return true;
        }

        return false;
    }

}
