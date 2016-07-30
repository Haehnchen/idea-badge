<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Intellij\IntellijPluginHtmlParser;
use espend\IdeaBadge\Poser\PoserBadge;
use espend\IdeaBadge\Poser\PoserGeneratorInterface;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserLastMonth implements PoserGeneratorInterface
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
     * @param IntellijPluginHtmlParser $parser
     * @param TextNormalizer $normalizer
     */
    public function __construct(IntellijPluginHtmlParser $parser, TextNormalizer $normalizer)
    {
        $this->parser = $parser;
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoser($id)
    {
        $content = explode("\n", $this->parser->get('downloadStatistic/csv?pluginId=' . $id . '&updateId=&period=month'));

        return new PoserBadge(
            'downloads',
            sprintf('%s last month', $this->formatDownloads($content)),
            '097ABB'
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'last-month';
    }

    /**
     * @param array $csvLines
     * @return string
     */
    private function formatDownloads(array $csvLines)
    {
        if (count($csvLines) < 2) {
            return 'n/a';
        }

        $downloads = explode(',', $csvLines[1]);
        if (count($downloads) < 2) {
            return 'n/a';
        }

        return $this->normalizer->normalize($downloads[1]);
    }
}