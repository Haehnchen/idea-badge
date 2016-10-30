<?php

namespace espend\IdeaBadgeBundle\Listener;

use espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage;
use espend\IdeaBadgeBundle\espendIdeaBadgeEvents;
use espend\IdeaBadgeBundle\Events\PluginDownloadsFetchedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MontlyBackupListener implements EventSubscriberInterface
{
    /**
     * @var PoserLastMonthStorage
     */
    private $storage;

    /**
     * @param PoserLastMonthStorage $storage
     */
    public function __construct(PoserLastMonthStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param PluginDownloadsFetchedEvent $event
     */
    public function onDownloadsFetched(PluginDownloadsFetchedEvent $event)
    {
        $this->storage->put($event->getId(), $event->getDownloads());
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            espendIdeaBadgeEvents::DOWNLOADS_FETCHED => 'onDownloadsFetched',
        ];
    }
}