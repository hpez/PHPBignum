<?php

namespace hpez\bignum;

require_once __DIR__.'/../vendor/autoload.php';

class BigInt extends BigNum
{
    /**
     * @param BigInt|string|integer $cmpNum
     * @return bool
     */
    public function isLesserThan($cmpNum)
    {
        if (gettype($cmpNum) == 'string' || gettype($cmpNum) == 'integer')
            $cmpNum = new BigInt($cmpNum);
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
     * @param BigInt|string|integer $cmpNum
     * @return bool
     */
    public function isBiggerThan($cmpNum)
    {
        if (is_numeric($cmpNum) || is_int($cmpNum))
            $cmpNum = new BigInt($cmpNum);
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
     * @param BigInt|string|integer $addNum
     * @return BigInt
     */
    public function add($addNum)
    {
        if (is_numeric($addNum) || is_int($addNum))
            $addNum = new BigInt($addNum);
        $addNumString = $addNum->number;
        $diff = $this->length() - strlen($addNumString);
        for ($i = 0; $i < $diff; $i++)
            $addNumString = '0'.$addNumString;

        $diff = strlen($addNumString) - $this->length();
        for ($i = 0; $i < $diff; $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($addNumString)-1; $i >= 0; $i--) {
            $value = ((int)($this->number[$i]) + (int)($addNumString[$i] + $carry)) % 10;
            $carry = floor(((int)($this->number[$i]) + (int)($addNumString[$i] + $carry)) / 10);
            $this->number[$i] = $value;
        }
        if ($carry != 0)
            $this->number = $carry.$this->number;

        return $this;
    }

    /**
     * @param BigInt|string|integer $subNum
     * @return BigInt
     */
    public function sub($subNum)
    {
        if (gettype($subNum) == 'string' || gettype($subNum) == 'integer')
            $subNum = new BigInt($subNum);
        $subNumString = $subNum->number;
        for ($i = 0; $i < $this->length() - strlen($subNumString); $i++)
            $subNumString = '0'.$subNumString;

        for ($i = 0; $i < strlen($subNumString) - strlen($this->number); $i++)
            $this->number = '0'.$this->number;

        $carry = 0;
        for ($i = strlen($subNumString)-1; $i >= 0; $i--) {
            $value = ((int)($this->number[$i]) - (int)($subNumString[$i] + $carry));
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
     * @param BigInt|string|integer $divNum
     * @return BigInt
     */
    public function div($divNum)
    {
        if (gettype($divNum) == 'string' || gettype($divNum) == 'integer')
            $divNum = new BigInt($divNum);
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
     * @param BigInt|string|integer $modNum
     * @return BigInt
     */
    public function mod($modNum)
    {
        if (gettype($modNum) == 'string' || gettype($modNum) == 'integer')
            $modNum = new BigInt($modNum);
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
            $quotient->rightPush((string)($count));
            if ($next < $modNum->length())
                $now->rightPush($this->number[$next]);
            $next++;
        } while($next < $modNum->length());

        $this->number = $now->number;

        return $this;
    }

    /**
     * @param BigInt|string|integer $multiplyNum
     * @return BigInt
     */
    public function multiply($multiplyNum)
    {
        if (gettype($multiplyNum) == 'string' || gettype($multiplyNum) == 'integer')
            $multiplyNum = new BigInt($multiplyNum);
        $result = new BigInt('0');
        for ($i = $this->length()-1; $i >= 0; $i--) {
            $carry = 0;
            $digitRes = new BigInt('');
            for ($j = $this->length()-1; $j > $i; $j--)
                $digitRes->rightPush('0');
            for ($j = $multiplyNum->length()-1; $j >= 0; $j--) {
                $value = ((int)($this->number[$i]) * (int)($multiplyNum->number[$j]) + $carry) % 10;
                $carry = floor(((int)($this->number[$i]) * (int)($multiplyNum->number[$j]) + $carry) / 10);
                $digitRes->leftPush($value);
            }
            if ($carry != 0)
                $digitRes->leftPush($carry);
            $result->add($digitRes);
        }
        $this->number = $result->number;

        return $this;
    }

    /**
     * @param BigInt|string|integer $powNum
     * @return BigInt
     */
    public function pow($powNum)
    {
        if (gettype($powNum) == 'string' || gettype($powNum) == 'integer')
            $powNum = new BigInt($powNum);
        $this->number = $this->powRecursive($powNum)->number;
        return $this;
    }

    /**
     * @param BigInt $powNum
     * @return BigInt|BigNum
     */
    private function powRecursive($powNum)
    {
        if ($powNum->equals(0))
            return new BigInt(1);
        if ($powNum->equals(1))
            return (new BigInt(''))->copy($this);

        $powNumC = (new BigInt(''))->copy($powNum);
        if ($powNumC->mod(2)->equals(0)) {
            $res = $this->powRecursive($powNum->div(2));
            $res->multiply($res);

            return $res;
        }
        
        $res = $this->powRecursive($powNum->div(2));
        $res2 = $this->powRecursive($powNum->add(1));
        $res->multiply($res2);

        return $res;
    }
}