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

    public function addGenerator(PoserGeneratorInterface $poser)
    {
        $this->posers[$poser::getName()] = $poser;
    }

    public function get($name)
    {
        return isset($this->posers[$name]) ? $this->posers[$name] : null;
    }

}