<?php

require_once __DIR__ . '/../vendor/autoload.php';

$parser = new \Sergeich5\PlayMarketParser\PlayMarketParser();

try {
    $app = $parser->getAppInfo('com.zhiliaoapp.musically');

    echo sprintf('App: %s', $app->title) . PHP_EOL;
    echo sprintf('BundleID: %s', $app->packageName) . PHP_EOL;
    echo sprintf('Rating: %f', $app->rating) . PHP_EOL;
    echo sprintf('Pic: %s', $app->pic) . PHP_EOL;
} catch (\Sergeich5\PlayMarketParser\Exceptions\ParseException $e) {
    echo 'Unable to parse ' . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    echo 'Unable to load' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}
