<?php

namespace App\Model;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

/*
 * @JMS\ExclusionPolicy("all")
 */
class Trk
{
    /**
     * @var Point[]
     *
     * @JMS\Expose()
     * @JMS\Type("ArrayCollection<App\Model\Point>")
     * @JMS\SerializedName("trkseg")
     * @JMS\XmlList(entry="trkpt")
     */
    protected $points;

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param Point $points
     * @return self
     */
    public function setPoints(Point $points): self
    {
        $this->points = $points;

        return $this;
    }
}