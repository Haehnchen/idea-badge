<?php

namespace espend\IdeaBadge\Poser;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
interface PoserGeneratorInterface
{
    /**
     * Get the poser to render
     *
     * @param $id
     * @return PoserBadge
     */
    public function getPoser($id);

    /**
     * Name of the provider, also the routing name
     *
     * @return string
     */
    public static function getName();
}