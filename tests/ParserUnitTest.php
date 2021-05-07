<?php


use PHPUnit\Framework\TestCase;
use Sergeich5\PlayMarketParser\Entities\App;

class ParserUnitTest extends TestCase
{
    function HTMLDataProvider(): array
    {
        $tiktok = new App();
        $tiktok->title = 'TikTok';
        $tiktok->rating = 5 - 0.5;
        $tiktok->pic = 'https://play-lh.googleusercontent.com/iBYjvYuNq8BB7EEEHktPG1fpX9NiY7Jcyg1iRtQxO442r9CZ8H-X9cLkTjpbORwWDG9d=s180-rw';
        $tiktok->packageName = 'com.zhiliaoapp.musically';

        return [[
            $tiktok,
            file_get_contents(__DIR__ . '/data/tiktok.html'),
            $tiktok->packageName
        ]];
    }

    /**
     * @dataProvider HTMLDataProvider
     */
    function testParseAppInfoFromHtml(App $expected, string $html, string $packageName): void
    {
        /* @var App $app */
        $app = PHPUnitUtil::callMethod(
            new \Sergeich5\PlayMarketParser\PlayMarketParser(),
            'parseAppInfoFromHtml',
            array($html, $packageName)
        );

        $this->assertEquals($expected->title, $app->title);
        $this->assertEquals($expected->pic, $app->pic);
        $this->assertEquals($expected->packageName, $app->packageName);
        $this->assertEquals($expected->rating, $app->rating);
    }
}
