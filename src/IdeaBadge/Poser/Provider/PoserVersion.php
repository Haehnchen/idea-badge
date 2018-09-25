<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Intellij\IntellijPluginHtmlParser;
use espend\IdeaBadge\Poser\PoserBadge;
use espend\IdeaBadge\Poser\PoserGeneratorInterface;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserVersion implements PoserGeneratorInterface
{
    /**
     * @var IntellijPluginHtmlParser
     */
    private $parser;

    /**
     * @param IntellijPluginHtmlParser $parser
     */
    public function __construct(IntellijPluginHtmlParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoser($id)
    {
        if(!$json = json_decode($this->parser->get('plugin/updates?pluginId='. $id .'&start=0&size=1'), true)) {
            return $this->createBadge('n/a');
        }

        if(!isset($json['updates'][0]['version'])) {
            return $this->createBadge('n/a');
        }

        return $this->createBadge($json['updates'][0]['version']);
    }

    /**
     * @param string $text
     * @return PoserBadge
     */
    private function createBadge($text)
    {
        return new PoserBadge('version', $text, '2D9BD1');
    }

    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'version';
    }
}