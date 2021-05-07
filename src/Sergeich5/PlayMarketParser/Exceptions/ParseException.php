<?php


namespace Sergeich5\PlayMarketParser\Exceptions;


class ParseException extends \Exception
{
    function __construct($field = "")
    {
        parent::__construct(sprintf('Unable to parse "%s"', $field));
    }
}
