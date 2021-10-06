<?php declare(strict_types=1);

namespace Ares\Model\Basic;

use JMS\Serializer\Annotation as JMS;

class Activities
{

    /**
     * @JMS\XmlList(inline = true, entry = "D:Obor_cinnosti")
     * @JMS\Type("array<Ares\Model\Basic\Activity>")
     *
     * @var \Ares\Model\Basic\Activity[]|array
     */
    private $list = [];

    /**
     * Returns list of business activities
     *
     * @return \Ares\Model\Basic\Activity[]|array
     */
    public function getList(): array
    {
        return $this->list;
    }

}
