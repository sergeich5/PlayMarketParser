<?php

namespace Sergeich5\PlayMarketParser;

use GuzzleHttp\Client;
use Sergeich5\PlayMarketParser\Entities\App;
use Sergeich5\PlayMarketParser\Entities\Proxy;
use Sergeich5\PlayMarketParser\Exceptions\ParseException;

class PlayMarketParser
{
    /* @var ?string $proxy */
    private $proxy;

    /* @var Client $client */
    private $client;

    function __construct(?Proxy $proxy = null)
    {
        $this->setProxy($proxy);
    }

    function setProxy(?Proxy $proxy): self
    {
        $options = [];
        if (!is_null($proxy)) {
            $url = 'http://';
            if (!is_null($proxy->getUser())) {
                $url .= $proxy->getUser();
                if (!is_null($proxy->getPassword()))
                    $url .= sprintf(':%s', $proxy->getPassword());
                $url .= '@';
            }
            $url = sprintf('%s:%d', $proxy->getHost(), $proxy->getPort());

            $options[\GuzzleHttp\RequestOptions::PROXY] = [$url];
        }

        $this->client = new Client($options);

        return $this;
    }

    function removeProxy(): self
    {
        return $this->setProxy(null);
    }

    function getAppInfo(string $packageName): App
    {
        $html = $this->loadHtml('https://play.google.com/store/apps/details?' . http_build_query(['id' => $packageName]));

        return $this->parseAppInfoFromHtml($html, $packageName);
    }

    private function parseAppInfoFromHtml(string $html, string $packageName): App
    {
        $html = str_get_html($html);

        if (is_null($html))
            throw new ParseException('document');

        $app = new App();
        $app->packageName = $packageName;

        try {
            $title = $html->find('h1 > span')[0]->plaintext;
            $app->title = $title;
        } catch (\Exception $e) {
            throw new ParseException('app title');
        }

        try {
            $stars = $html->find('[role="img"]')[1];
            $app->rating = floatval(str_replace(',', '.', $stars->parent->parent->find('div')[0]->plaintext));
            unset($stars);
        } catch (\Exception $e) {
            throw new ParseException('app rating');
        }

        try {
            $images = $html->find('main img');
            if (count($images) == 0)
                throw new \Exception();
        } catch (\Exception $e) {
            throw new ParseException('app picture');
        }

        $app->pic = $images[0]->src;

        return $app;
    }

    private function loadHtml(string $url): string
    {
        $response = $this->client->get($url);
        return $response->getBody();
    }
}
