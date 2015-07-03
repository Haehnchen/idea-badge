<?php

namespace espend\IdeaBadge\Intellij;

use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class IntellijPluginHtmlParser
{

    private $lifetime = 600;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $host;

    public function __construct($cacheDir, $host = 'https://plugins.jetbrains.com/')
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        $this->host = $host;
    }

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

    public function filter($url, $selector)
    {
        $crawler = new Crawler($this->get($url));
        return $crawler->filter($selector)->text();
    }
}