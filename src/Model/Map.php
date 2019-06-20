<?php

namespace App\Model;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

/*
 * @JMS\ExclusionPolicy("all")
 */
class Map
{
    /**
     * @JMS\Expose()
     * @JMS\Type("App\Model\Trk")
     * @JMS\SerializedName("trk")
     */
    protected $trk;

    /**
     * @return mixed
     */
    public function getTrk()
    {
        return $this->trk;
    }

    /**
     * @param mixed $trk
     * @return self
     */
    public function setTrk($trk): self
    {
        $this->trk = $trk;

        return $this;
    }
}