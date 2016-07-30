<?php

namespace espend\IdeaBadge\Tests\Poser\Provider;

use espend\IdeaBadge\Poser\Provider\PoserDownloads;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserDownloadsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers espend\IdeaBadge\Poser\Provider\PoserDownloads::getPoser
     */
    public function testThatDownloadsEndpointIsSupported()
    {
        $parser = $this->getMockBuilder('espend\IdeaBadge\Intellij\IntellijPluginHtmlParser')
            ->disableOriginalConstructor()
            ->getMock();

        $parser->method('filter')->willReturn("\t \n  \t 4 00333    \t \n");

        $poser = new PoserDownloads($parser, new TextNormalizer());

        static::assertEquals(
            '400.33 k',
            $poser->getPoser('foobar')->getStatus()
        );
    }
}