<?php

namespace espend\IdeaBadge\Intellij;

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
    private $cacheDir;

    /**
     * @var string
     */
    private $host;

    /**
     * @param string $cacheDir
     * @param string $host
     */
    public function __construct($cacheDir, $host = 'https://plugins.jetbrains.com/')
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        $this->host = $host;
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

        $hash = md5($url);

        $filename = $this->cacheDir . '/' . $hash;

        if (is_file($filename) && time() - filemtime($filename) < $this->lifetime) {
            return file_get_contents($filename);
        }

        if ($content = file_get_contents($url)) {

            if (!is_dir(dirname($filename))) {
                mkdir(dirname($filename));
            }

            file_put_contents($filename, $content);
            return $content;
        }

        return null;
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