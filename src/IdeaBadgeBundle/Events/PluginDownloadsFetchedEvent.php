<?php

namespace espend\IdeaBadgeBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class PluginDownloadsFetchedEvent extends Event
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $downloads;

    /**
     * PluginDownloadsFetchEvent constructor.
     *
     * @param $id
     * @param $downloads
     */
    public function __construct($id, $downloads)
    {
        $this->id = $id;
        $this->downloads = $downloads;
    }

    /**
     * Plugin id 71xx
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDownloads()
    {
        return $this->downloads;
    }
}
