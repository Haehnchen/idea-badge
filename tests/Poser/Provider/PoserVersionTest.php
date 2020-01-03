<?php

namespace espend\IdeaBadge\Tests\Poser\Provider;

use espend\IdeaBadge\Poser\Provider\PoserVersion;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserVersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers espend\IdeaBadge\Poser\Provider\PoserVersion::getPoser
     */
    public function testThatLastVersionEndpointIsSupported()
    {
        $parser = $this->getMockBuilder('espend\IdeaBadge\Intellij\IntellijPluginHtmlParser')
            ->disableOriginalConstructor()
            ->getMock();

        $parser->method('get')->willReturn(
            file_get_contents(__DIR__ . '/Fixtures/updates.json')
        );

        static::assertEquals(
            '0.19.187',
            (new PoserVersion($parser))->getPoser('7219')->getStatus()
        );
    }
}
