<?php

namespace espend\IdeaBadge\Poser;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserBadge
{

    private $subject;
    private $status;
    private $color;

    public function __construct($subject, $status, $color)
    {
        $this->subject = $subject;
        $this->status = $status;
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}