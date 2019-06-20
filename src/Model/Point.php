<?php

namespace App\Model;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

/*
 * @JMS\ExclusionPolicy("all")
 */
class Point
{
    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\SerializedName("lat")
     * @JMS\XmlAttribute()
     * @JMS\Type("string")
     */
    protected $lat;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\SerializedName("lon")
     * @JMS\XmlAttribute()
     * @JMS\Type("string")
     */
    protected $lon;

    /**
     * @var string
     *
     * @JMS\Expose()
     * @JMS\SerializedName("ele")
     * @JMS\Type("string")
     */
    protected $ele;

    /**
     * @var \DateTime
     *
     * @JMS\Expose()
     * @JMS\SerializedName("time")
     * @JMS\Type("DateTime<'Y-m-d\TH:i:sO'>")
     */
    protected $date;

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     * @return self
     */
    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return string
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param string $lon
     * @return self
     */
    public function setLon(string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return string
     */
    public function getEle(): string
    {
        return $this->ele;
    }

    /**
     * @param string $ele
     * @return self
     */
    public function setEle(string $ele): self
    {
        $this->ele = $ele;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return self
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}