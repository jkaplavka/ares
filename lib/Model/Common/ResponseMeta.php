<?php declare(strict_types=1);

namespace Ares\Model\Common;

use DateTimeImmutable;
use DateTimeZone;
use JMS\Serializer\Annotation as JMS;

/**
 * Root level API response object containing meta informations and all responses
 *
 * @JMS\XmlNamespace(uri="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3", prefix="are")
 * @JMS\XmlNamespace(uri="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3", prefix="D")
 * @JMS\XmlNamespace(uri="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/uvis_datatypes/v_1.0.3", prefix="U")
 *
 * @JMS\XmlRoot("are:Ares_odpovedi")
 */
class ResponseMeta
{

    /**
     * @JMS\XmlAttribute
     * @JMS\Type("DateTimeImmutable<'Y-m-d\TH:i:s', 'Europe/Prague'>")
     * @JMS\SerializedName("odpoved_datum_cas")
     *
     * @var \DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @JMS\XmlAttribute
     * @JMS\SerializedName("odpoved_pocet")
     *
     * @var int
     */
    private int $responsesCount = 0;

    /**
     * @JMS\SerializedName("odpoved_datum_cas")
     * @JMS\XmlList(inline = true, entry = "are:Odpoved")
     * @JMS\Type("array<Ares\Model\Common\Response>")
     *
     * @var \Ares\Model\Common\Response[]|array
     */
    private $responses = [];

    /**
     * Returns datetime when was request created in UTC timezone
     *
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt->setTimezone(new DateTimeZone('UTC'));
    }

    /**
     * Returns total number of responses
     *
     * @return int
     */
    public function getResponsesCount(): int
    {
        return $this->responsesCount;
    }

    /**
     * Returns all responses
     *
     * @return \Ares\Model\Common\Response[]|array
     */
    public function getResponses(): array
    {
        return $this->responses;
    }

    /**
     * Returns first response
     *
     * @return \Ares\Model\Common\Response|null
     */
    public function getFirstResponse(): ?Response
    {
        return $this->responses[0] ?? null;
    }

}
