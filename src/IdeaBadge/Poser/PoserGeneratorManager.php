<?php

namespace espend\IdeaBadge\Poser;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserGeneratorManager
{
    /**
     * @var PoserGeneratorInterface[]
     */
    private $posers = array();

    /**
     * @param PoserGeneratorInterface $poser
     */
    public function addGenerator(PoserGeneratorInterface $poser)
    {
        $this->posers[$poser::getName()] = $poser;
    }

    /**
     * @param string $name
     * @return PoserGeneratorInterface|null
     */
    public function get($name)
    {
        return isset($this->posers[$name]) ? $this->posers[$name] : null;
    }
}