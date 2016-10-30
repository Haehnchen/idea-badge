<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Intellij\IntellijPluginHtmlParser;
use espend\IdeaBadge\Poser\PoserBadge;
use espend\IdeaBadge\Poser\PoserGeneratorInterface;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;
use espend\IdeaBadgeBundle\espendIdeaBadgeEvents;
use espend\IdeaBadgeBundle\Events\PluginDownloadsFetchedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserDownloads implements PoserGeneratorInterface
{
    /**
     * @var IntellijPluginHtmlParser
     */
    private $parser;

    /**
     * @var TextNormalizer
     */
    private $normalizer;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param IntellijPluginHtmlParser $parser
     * @param TextNormalizer $normalizer
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        IntellijPluginHtmlParser $parser,
        TextNormalizer $normalizer,
        EventDispatcherInterface $dispatcher
    ) {
        $this->parser = $parser;
        $this->normalizer = $normalizer;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoser($id)
    {
        $formatted = 'n/a';

        if($downloads = $this->getDownloads($id)) {
            $formatted = $downloads;
        }

        return new PoserBadge('downloads', $formatted, '097ABB');
    }

    /**
     * @param string $id
     * @return null|string
     */
    private function getDownloads($id)
    {
        if($downloads = $this->parser->filter('plugin/' . $id, '.plugin-info__downloads')) {
            // "4 645"
            $downloads = str_replace(' ', '', trim($downloads));

            $this->dispatcher->dispatch(
                espendIdeaBadgeEvents::DOWNLOADS_FETCHED,
                new PluginDownloadsFetchedEvent($id, $downloads)
            );

            return $this->normalizer->normalize($downloads);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'downloads';
    }
}