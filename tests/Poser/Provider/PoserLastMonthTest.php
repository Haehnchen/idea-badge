<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Poser\Utils\TextNormalizer;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserLastMonthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonth::getPoser
     */
    public function testThatLastMonthEndpointIsSupported()
    {
        $parser = $this->getMockBuilder('espend\IdeaBadge\Intellij\IntellijPluginHtmlParser')
            ->disableOriginalConstructor()
            ->getMock();

        $parser->method('get')->willReturn("key,value\nfoobar,5938334\n");

        $poser = new PoserLastMonth($parser, new TextNormalizer());

        static::assertEquals(
            '5.94 M last month',
            $poser->getPoser('foobar')->getStatus()
        );
    }

    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonth::getPoser
     */
    public function testThatLastMonthErrorIsNotAvailable()
    {
        $parser = $this->getMockBuilder('espend\IdeaBadge\Intellij\IntellijPluginHtmlParser')
            ->disableOriginalConstructor()
            ->getMock();

        $parser->method('get')->willReturn("foobar,5938334\n");

        $poser = new PoserLastMonth($parser, new TextNormalizer());

        static::assertEquals(
            'n/a last month',
            $poser->getPoser('foobar')->getStatus()
        );
    }
}