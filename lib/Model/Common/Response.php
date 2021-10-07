<?php declare(strict_types=1);

namespace Ares\Model\Common;

use Ares\Model\Basic\BasicInfo;
use JMS\Serializer\Annotation as JMS;

/**
 * Response from ARES API could contain actual informations about single business entity or error
 */
class Response
{

    /**
     * @JMS\SerializedName("D:VBAS")
     * @JMS\Type(BasicInfo::class)
     *
     * @var \Ares\Model\Basic\BasicInfo|null
     */
    private ?BasicInfo $basicInfo = null;

    /**
     * @JMS\SerializedName("D:E")
     * @JMS\Type(ResponseError::class)
     *
     * @var \Ares\Model\Common\ResponseError|null
     */
    private ?ResponseError $error = null;

    /**
     * Returns basic informations about business entity
     *
     * @return \Ares\Model\Basic\BasicInfo|null
     */
    public function getBasicInfo(): ?BasicInfo
    {
        return $this->basicInfo;
    }

    /**
     * Returns error response
     *
     * @return \Ares\Model\Common\ResponseError|null
     */
    public function getError(): ?ResponseError
    {
        return $this->error;
    }

    public function isError(): bool
    {
        return $this->error !== null;
    }

}
