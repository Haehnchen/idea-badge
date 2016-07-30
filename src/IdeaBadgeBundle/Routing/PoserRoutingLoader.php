<?php

namespace espend\IdeaBadgeBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserRoutingLoader extends Loader
{
    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * @var array
     */
    private $providerNames;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $controllerName;

    public function __construct($controllerName, $routePath, array $providerNames)
    {
        $this->path = $routePath;
        $this->providerNames = $providerNames;
        $this->controllerName = $controllerName;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "espend_poser" loader twice');
        }

        $this->loaded = true;

        $routes = new RouteCollection();
        if(count($this->providerNames) == 0) {
            return $routes;
        }

        foreach($this->providerNames as $provider) {
            $route = new Route(str_replace('{provider}', $provider, $this->path), [
                '_controller' => $this->controllerName,
                'provider' => $provider,
            ], [
                'id' => '(\d){1,5}',
            ]);

            $routes->add('espend_idea_' . preg_replace("/[^\\w]/", '_', $provider), $route);
        }

        return $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return 'espend_idea_badge' === $type;
    }
}