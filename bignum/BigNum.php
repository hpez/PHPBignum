<?php

namespace hpez\bignum;

require_once __DIR__.'/../vendor/autoload.php';

class BigNum
{
    protected $number;

    /**
     * BigNum constructor.
     * @param string|integer|double $number
     */
    public function __construct($number)
    {
        $this->number = strval($number);
    }

    /**
     * @return int
     */
    protected function length()
    {
        return strlen($this->number);
    }

    /**
     * @param BigNum|string|integer|double $bigNum
     * @return bool
     */
    public function equals($bigNum)
    {
        if (gettype($bigNum) == 'string' || gettype($bigNum) == 'integer')
            $bigNum = new BigNum($bigNum);
        return $this->number == $bigNum->number;
    }

    /**
     * @param BigNum $bigNum
     * @return BigNum
     */
    public function copy($bigNum)
    {
        $this->number = $bigNum->number;
        return $this;
    }


    /**
     * @param string $digit
     */
    protected function rightPush($digit)
    {
        $this->number = $this->number.$digit;
    }

    /**
     * @param string $digit
     */
    protected function leftPush($digit)
    {
        $this->number = $digit.$this->number;
    }

    protected function clearLeadingZeros()
    {
        $i = 0;
        while ($this->number[$i] == '0')
            $i++;
        $this->number = substr($this->number, $i, $this->length() - $i);
        return $this;
    }
}