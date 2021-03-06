<?php

namespace espend\IdeaBadge\Tests\Poser\Provider;

use espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage;

class PoserLastMonthStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $temp;

    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage::fetch
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage::keys
     */
    public function testThatLastMonthIsLoaded()
    {
        $storage = new PoserLastMonthStorage($this->temp);

        static::assertEquals(5, $storage->fetch('7311'));
        static::assertContains(7311, $storage->keys());
    }

    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage::fetch
     */
    public function testThatLastMonthInvalidatesToNotAvailable()
    {
        $storage = new PoserLastMonthStorage($this->temp);

        static::assertNull($storage->fetch('8312'));
    }

    /**
     * @covers \espend\IdeaBadge\Poser\Provider\PoserLastMonthStorage::put
     */
    public function testThatCurrentMonthIsSaved()
    {
        $storage = new PoserLastMonthStorage($this->temp);
        $storage->put('5000', 500000);

        $json = json_decode(file_get_contents($this->temp), true);
        static::assertEquals(500000, current($json['5000']));
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $contents = [
            '7311' => [
                date_create()->modify('first day of this month')->modify('-2 month')->format('Y-m') => 10,
                date_create()->modify('first day of this month')->modify('-1 month')->format('Y-m') => 15,
            ],
            '8312' => [
                date_create()->modify('first day of this month')->modify('-2 month')->format('Y-m') => 15,
                date_create()->modify('first day of this month')->modify('-1 month')->format('Y-m') => 10,
            ],
        ];

        $this->temp = tempnam(sys_get_temp_dir(), 'FOO');
        file_put_contents($this->temp, json_encode($contents));
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unlink($this->temp);
    }
}