<?php

namespace hpez\BigNum;

require_once __DIR__.'/../vendor/autoload.php';

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
     * @param BigInt $cmpNum
     * @return bool
     */
    public function isLesserThan($cmpNum)
    {
        if ($this->length() < $cmpNum->length())
            return true;
        elseif ($cmpNum->length() < $this->length())
            return false;
        else
            for ($i = 0; $i < $this->length(); $i++)
                if ($this->number[$i] < $cmpNum->number[$i])
                    return true;
                elseif ($cmpNum->number[$i] < $this->number[$i])
                    return false;

        return false;
    }

    /**
     * @param BigInt $cmpNum
     * @return bool
     */
    public function isBiggerThan($cmpNum)
    {
        if ($this->length() > $cmpNum->length())
            return true;
        elseif ($cmpNum->length() > $this->length())
            return false;
        else
            for ($i = 0; $i < $this->length(); $i++)
                if ($this->number[$i] > $cmpNum->number[$i])
                    return true;
                elseif ($cmpNum->number[$i] > $this->number[$i])
                    return false;

        return false;
    }

    /**
     * @return int
     */
    protected function length()
    {
        return strlen($this->number);
    }

    /**
     * @param string $digit
     */
    protected function rightPush($digit)
    {
        $this->number = $this->number.$digit;
    }

    /**
     * @param BigInt $addNum
     * @return BigInt
     */
    public function add($addNum)
    {
        $addNumString = $addNum->number;
        for ($i = 0; $i < $this->length() - strlen($addNumString); $i++)
            $addNumString = '0'.$addNumString;

        for ($i = 0; $i < strlen($addNumString) - $this->length(); $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($addNumString)-1; $i >= 0; $i--) {
            $value = (intval($this->number[$i]) + intval($addNumString[$i] + $carry)) % 10;
            $carry = floor((intval($this->number[$i]) + intval($addNumString[$i] + $carry)) / 10);
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
    public function sub($subNum)
    {
        $subNumString = $subNum->number;
        for ($i = 0; $i < $this->length() - strlen($subNumString); $i++)
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

    /**
     * @param BigInt $divNum
     * @return BigInt
     */
    public function div($divNum)
    {
        if ($divNum->isBiggerThan($this)) {
            $this->number = '0';
            return $this;
        }

        $quotient = new BigInt('');
        $now = new BigInt(substr($this->number, 0, $divNum->length()));
        $next = $divNum->length();
        do {
            $count = 0;
            while ($divNum <= $now) {
                $now->sub($divNum);
                $count++;
            }
            $quotient->rightPush(strval($count));
            $now->rightPush($this->number[$next]);
            $next++;
        } while($next < $divNum->length());

        $this->number = $quotient;

        return $this;
    }
}