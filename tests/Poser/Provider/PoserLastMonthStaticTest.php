<?php

namespace espend\IdeaBadge\Tests\Poser\Provider;

use espend\IdeaBadge\Poser\Provider\PoserLastMonthStatic;
use espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;

class PoserLastMonthStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonthStatic::getPoser
     */
    public function testThatBadgeIsBuild()
    {
        $storage = $this->getMockBuilder(PoserLastMonthStorage::class)
            ->disableOriginalConstructor()->getMock();

        $storage->method('fetch')->with('7311')->willReturn(12000);

        $provider = new PoserLastMonthStatic($storage, new TextNormalizer());

        static::assertEquals('12 k last month', $provider->getPoser('7311')->getStatus());
    }
}
