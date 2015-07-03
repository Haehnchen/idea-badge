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

        $downloads = $this->parser->filter('plugin/' . $id, '#main .rating .label');
        if (preg_match('#downloads[:]*\s*(\d+)#i', $downloads, $result)) {
            $formatted = $this->normalizer->normalize($result[1]);
        } else {
            $formatted = 'n/a';
        }

        return new PoserBadge(
            'downloads',
            $formatted,
            '097ABB'
        );
    }

    public static function getName()
    {
        return 'downloads';
    }

}