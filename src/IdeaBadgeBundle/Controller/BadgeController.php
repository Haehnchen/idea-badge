<?php

namespace espend\IdeaBadgeBundle\Controller;

use espend\IdeaBadge\Poser\PoserGeneratorManager;
use PUGX\Poser\Poser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class BadgeController extends Controller
{

    /**
     * @var PoserGeneratorManager
     */
    private $manager;

    /**
     * @var int
     */
    private $badgeLifetime;

    /**
     * @var Poser
     */
    private $poser;

    /**
     * @param PoserGeneratorManager $manager
     * @param Poser $poser
     * @param int $badgeLifetime
     */
    public function __construct(PoserGeneratorManager $manager, Poser $poser, $badgeLifetime)
    {
        $this->manager = $manager;
        $this->badgeLifetime = $badgeLifetime;
        $this->poser = $poser;
    }

    /**
     * @param int|string $id
     * @param string $provider
     * @return Response
     */
    public function showAction($id, $provider)
    {
        // this handled by routing loader, but not throw error in this conditional case here
        if (null === $poserProvider = $this->manager->get($provider)) {
            throw new NotFoundHttpException(sprintf('Provider for badge "%s" not found', $provider));
        }

        $poser = $poserProvider->getPoser($id);

        $content = $this->poser->generate(
            $poser->getSubject(),
            $poser->getStatus(),
            $poser->getColor(),
            'flat'
        );

        return new Response($content, 200, [
            'Cache-Control' => 's-maxage='. $this->badgeLifetime .', public',
            'Content-Disposition' => sprintf('inline; filename="%s-%s.svg"', $provider, $id),
            'Content-Type' => 'image/svg+xml;charset=utf-8',
        ]);
    }
}
