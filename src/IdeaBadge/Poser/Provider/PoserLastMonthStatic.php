<?php

namespace espend\IdeaBadge\Poser\Provider;

use espend\IdeaBadge\Poser\PoserBadge;
use espend\IdeaBadge\Poser\PoserGeneratorInterface;
use espend\IdeaBadge\Poser\Utils\TextNormalizer;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserLastMonthStatic implements PoserGeneratorInterface
{
    /**
     * @var TextNormalizer
     */
    private $normalizer;

    /**
     * @var PoserLastMonthStorage
     */
    private $storage;

    /**
     * @param PoserLastMonthStorage $storage
     * @param TextNormalizer $normalizer
     */
    public function __construct(PoserLastMonthStorage $storage, TextNormalizer $normalizer)
    {
        $this->storage = $storage;
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getPoser($id)
    {
        $count = 'n/a';
        if ($downloads = $this->storage->fetch($id)) {
            $count = $this->normalizer->normalize($downloads);
        }

        return new PoserBadge(
            'downloads',
            sprintf('%s last month', $count),
            '097ABB'
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'last-month';
    }
}