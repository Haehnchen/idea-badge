<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Intellij\IntellijPluginHtmlParser;
use espend\IdeaBadge\Poser\PoserBadge;
use espend\IdeaBadge\Poser\PoserGeneratorInterface;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;

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
        $formatted = 'n/a';
        if($downloads = $this->parser->filter('plugin/' . $id, '.plugin-info__downloads')) {
            // "4 645"
            $formatted = $this->normalizer->normalize(str_replace(' ', '', trim($downloads)));
        }

        return new PoserBadge('downloads', $formatted, '097ABB');
    }

    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'downloads';
    }
}