<?php

namespace hpez\bignum;

require_once __DIR__.'/../vendor/autoload.php';

class BigInt extends BigNum
{
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

    /**
     * @param BigInt $addNum
     * @return BigInt
     */
    public function add($addNum)
    {
        $addNumString = $addNum->number;
        $diff = $this->length() - strlen($addNumString);
        for ($i = 0; $i < $diff; $i++)
            $addNumString = '0'.$addNumString;

        $diff = strlen($addNumString) - $this->length();
        for ($i = 0; $i < $diff; $i++)
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
            $value = (intval($this->number[$i]) - intval($subNumString[$i] + $carry));
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
            if ($next < $divNum->length())
                $now->rightPush($this->number[$next]);
            $next++;
        } while($next < $divNum->length());

        $this->number = $quotient->number;

        return $this;
    }

    /**
     * @param BigInt $modNum
     * @return BigInt
     */
    public function mod($modNum)
    {
        if ($modNum->isBiggerThan($this))
            return $this;

        $quotient = new BigInt('');
        $now = new BigInt(substr($this->number, 0, $modNum->length()));
        $next = $modNum->length();
        do {
            $count = 0;
            while ($modNum <= $now) {
                $now->sub($modNum);
                $count++;
            }
            $quotient->rightPush(strval($count));
            if ($next < $modNum->length())
                $now->rightPush($this->number[$next]);
            $next++;
        } while($next < $modNum->length());

        $this->number = $now->number;

        return $this;
    }

    /**
     * @param BigInt $multiplyNum
     * @return BigInt
     */
    public function multiply($multiplyNum)
    {
        $result = new BigInt('0');
        for ($i = $this->length()-1; $i >= 0; $i--) {
            $carry = 0;
            $digitRes = new BigInt('');
            for ($j = $multiplyNum->length()-1; $j > $i; $j--)
                $digitRes->rightPush('0');
            for ($j = $multiplyNum->length()-1; $j >= 0; $j--) {
                $value = (intval($this->number[$i]) * intval($multiplyNum->number[$j]) + $carry) % 10;
                $carry = floor((intval($this->number[$i]) * intval($multiplyNum->number[$j]) + $carry) / 10);
                $digitRes->leftPush($value);
            }
            if ($carry != 0)
                $digitRes->leftPush($carry);
            $result->add($digitRes);
        }
        $this->number = $result->number;

        return $this;
    }
}