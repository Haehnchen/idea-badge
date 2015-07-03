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

    public function __construct(IntellijPluginHtmlParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoser($id)
    {

        $version = trim($this->parser->filter('plugin/' . $id, '.version_table tr:nth-child(2) td:first-child'));
        if (strlen($version) == 0) {
            $version = 'n/a';
        }

        return new PoserBadge('version', $version, '2D9BD1');
    }

    public static function getName()
    {
        return 'version';
    }
}