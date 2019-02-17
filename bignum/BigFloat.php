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
     * @param BigFloat|string|double $addNum
     * @return BigFloat
     */
    public function add($addNum)
    {
        if (gettype($addNum) == 'string' || gettype($addNum) == 'double')
            $addNum = new BigFloat($addNum);
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
                $value = ((int)($this->number[$i]) + (int)($addNumString[$i] + $carry)) % 10;
                $carry = floor(((int)($this->number[$i]) + (int)($addNumString[$i] + $carry)) / 10);
                $this->number[$i] = $value;
            }
        }
        if ($carry != 0)
            $this->number = $carry.$this->number;

        return $this;
    }

    /**
     * @param BigFloat|string|double $subNum
     * @return BigFloat
     */
    public function sub($subNum)
    {
        if (gettype($subNum) == 'string' || gettype($subNum) == 'double')
            $subNum = new BigFloat($subNum);
        $subNumString = $subNum->number;
        $diff = $this->decLength() - $subNum->decLength();
        for ($i = 0; $i < $diff; $i++)
            $subNumString .= '0';

        $diff = $subNum->decLength() - $this->decLength();
        for ($i = 0; $i < $diff; $i++)
            $this->number .= '0';

        $diff = $this->intLength() - $subNum->intLength();
        for ($i = 0; $i < $diff; $i++)
            $subNumString = '0'.$subNumString;

        $diff = $subNum->intLength() - $this->intLength();
        for ($i = 0; $i < $diff; $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($subNumString)-1; $i >= 0; $i--) {
            if ($this->number[$i] != '.') {
                $value = ((int)($this->number[$i]) - (int)($subNumString[$i] + $carry));
                if ($value < 0) {
                    $carry = 1;
                    $value += 10;
                } else
                    $carry = 0;
                $this->number[$i] = $value;
            }
        }

        return $this;
    }
}