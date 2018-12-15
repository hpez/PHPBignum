<?php

namespace hpez\bignum;


class BigFloat extends BigNum
{
    /**
     * @return bool|int
     */
    protected function intLength()
    {
        return strpos($this->number, '.');
    }

    /**
     * @return int
     */
    protected function decLength()
    {
        return $this->length() - $this->intLength();
    }

    /**
     * @param BigFloat $addNum
     * @return BigFloat
     */
    public function add($addNum)
    {
        $addNumString = $addNum->number;
        $diff = $this->decLength() - $addNum->decLength();
        for ($i = 0; $i < $diff; $i++)
            $addNumString .= '0';

        $diff = $addNum->decLength() - $this->decLength();
        for ($i = 0; $i < $diff; $i++)
            $this->number .= '0';

        $diff = $this->intLength() - $addNum->intLength();
        for ($i = 0; $i < $diff; $i++)
            $addNumString = '0'.$addNumString;

        $diff = $addNum->intLength() - $this->intLength();
        for ($i = 0; $i < $diff; $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($addNumString) - 1; $i >= 0; $i--) {
            if ($this->number[$i] != '.') {
                $value = (intval($this->number[$i]) + intval($addNumString[$i] + $carry)) % 10;
                $carry = floor((intval($this->number[$i]) + intval($addNumString[$i] + $carry)) / 10);
                $this->number[$i] = $value;
            }
        }
        if ($carry != 0)
            $this->number = $carry.$this->number;

        return $this;
    }
}