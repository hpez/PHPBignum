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
        $this->number = (string)$number;
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
        if (is_numeric($bigNum) || is_int($bigNum))
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
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
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
        if ($this->number == "0") return $this;
        $iterator = 0;
        while ($iterator < $this->length() && $this->number[$iterator] == '0')
            $iterator++;
        $this->number = substr($this->number, $iterator, $this->length() - $iterator);
        return $this;
    }
}
