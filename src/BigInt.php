<?php

namespace BigNum;


class BigInt
{
    protected $number;

    /**
     * BigInt constructor.
     * @param string $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @param BigInt $addNum
     * @return BigInt
     */
    public function add($addNum)
    {
        $addNumString = $addNum->number;
        for ($i = 0; $i < strlen($this->number) - strlen($addNumString); $i++)
            $addNumString = '0'.$addNumString;

        for ($i = 0; $i < strlen($addNumString) - strlen($this->number); $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($addNumString)-1; $i >= 0; $i--) {
            $value = (intval($this->number[$i]) + intval($addNumString[$i] + $carry)) % 10;
            $carry = (intval($this->number[$i]) + intval($addNumString[$i] + $carry)) / 10;
            $this->number[$i] = $value;
        }
        if ($carry != 0)
            $this->number = $carry.$this->number;

        return $this;
    }

    /**
     * @param BigInt $subNum
     * @return BigInt
     */
    public function subtract($subNum)
    {
        $subNumString = $subNum->number;
        for ($i = 0; $i < strlen($this->number) - strlen($subNumString); $i++)
            $subNumString = '0'.$subNumString;

        for ($i = 0; $i < strlen($subNumString) - strlen($this->number); $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($subNumString)-1; $i >= 0; $i--) {
            $value = (intval($this->number[$i]) - intval($subNumString[$i] - $carry));
            if ($value < 0) {
                $carry = 1;
                $value += 10;
            } else
                $carry = 0;
            $this->number[$i] = $value;
        }

        return $this;
    }
}