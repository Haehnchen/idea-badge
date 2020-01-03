<?php

namespace espend\IdeaBadge\Tests\Poser\Provider;

use espend\IdeaBadge\Poser\Provider\PoserDownloads;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;
use Symfony\Component\EventDispatcher\EventDispatcher;

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

        $parser->method('get')->willReturn(
            file_get_contents(__DIR__ . '/Fixtures/getPluginInfo.json')
        );

        $poser = new PoserDownloads($parser, new TextNormalizer(), new EventDispatcher());

        static::assertEquals(
            '3.72 M',
            $poser->getPoser('foobar')->getStatus()
        );
    }
}
