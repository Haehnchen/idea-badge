<?php

namespace espend\IdeaBadge\Poser\Provider;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserLastMonthStorage
{
    /**
     * @var string
     */
    private $pathname;

    /**
     * PoserLastMonthStorage constructor.
     * @param string $pathname
     */
    public function __construct($pathname)
    {
        $this->pathname = $pathname;
    }

    /**
     * @param string $id
     * @return int|null
     */
    public function fetch($id)
    {
        $lastMonth = date_create()->modify('-1 month')->format('Y-m');
        $prevMonth = date_create()->modify('-2 month')->format('Y-m');

        $content = $this->getContent();
        if (!isset($content[$id][$lastMonth], $content[$id][$prevMonth])) {
            return null;
        }

        if(($value = $content[$id][$lastMonth] - $content[$id][$prevMonth]) > 0) {
            return $value;
        }

        return null;
    }

    /**
     * @param string $id
     * @param $downloads
     */
    public function put($id, $downloads)
    {
        $contents = $this->getContent();

        $currentMonth = date_create()->format('Y-m');
        $contents[$id][$currentMonth] = $downloads;

        file_put_contents($this->pathname, json_encode($contents));
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->getContent());
    }

    /**
     * @return null
     */
    private function getContent()
    {
        if (!is_file($this->pathname)) {
            return [];
        }

        if ($content = json_decode(file_get_contents($this->pathname), true)) {
            return $content;
        }

        return [];
    }
}
