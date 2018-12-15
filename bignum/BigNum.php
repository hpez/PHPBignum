<?php

namespace hpez\bignum;

require_once __DIR__.'/../vendor/autoload.php';

class BigNum
{
    protected $number;

    /**
     * BigNum constructor.
     * @param string $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    protected function length()
    {
        return strlen($this->number);
    }
}