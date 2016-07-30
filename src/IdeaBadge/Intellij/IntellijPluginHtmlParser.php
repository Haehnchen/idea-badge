<?php

namespace espend\IdeaBadge\Intellij;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class IntellijPluginHtmlParser
{
    /**
     * Content cache life time
     *
     * @var int
     */
    private $lifetime = 600;

    /**
     * @var string
     */
    private $host;

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * @param CacheItemPoolInterface $cacheItemPool
     * @param string $host
     */
    public function __construct(
        CacheItemPoolInterface $cacheItemPool,
        $host = 'https://plugins.jetbrains.com/'
    )
    {
        $this->host = $host;
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * Load content and cache it
     *
     * @param $url
     * @return null|string
     */
    public function get($url)
    {
        $url = $this->host . $url;
        $hash = 'url-parser' . md5($url);

        $cache = $this->cacheItemPool->getItem($hash);
        if($cache->isHit()) {
            return $cache->get();
        }

        // no error handling; trust and cache every request
        $content = @file_get_contents($url);

        $cache->set($content);
        $cache->expiresAfter($this->lifetime);

        $this->cacheItemPool->save($cache);

        return $content;
    }

    /**
     * Filter content url by css selector
     *
     * @param string $url
     * @param string $selector css selector
     * @return string|null;
     */
    public function filter($url, $selector)
    {
        if(!$content = $this->get($url)) {
            return null;
        }

        $result = (new Crawler($content))->filter($selector);
        if($result->count() == 0) {
            return null;
        }

        return $result->text();
    }
}