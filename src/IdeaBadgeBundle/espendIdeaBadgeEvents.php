<?php

namespace espend\IdeaBadgeBundle;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
final class espendIdeaBadgeEvents
{
    /**
     * @Event("espend\IdeaBadgeBundle\Events\PluginDownloadsFetchedEvent")
     */
    const DOWNLOADS_FETCHED = 'espend_idea_badge.downloads_fetched';

    private function __constructor() {}
}