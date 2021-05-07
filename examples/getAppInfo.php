<?php

require_once __DIR__ . '/../vendor/autoload.php';

$parser = new \Sergeich5\PlayMarketParser\PlayMarketParser();
var_dump($parser->getAppInfo('com.zhiliaoapp.musically'));
