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
        if (is_numeric($cmpNum) || is_int($cmpNum))
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
        if (is_numeric($subNum) || is_int($subNum))
            $subNum = new BigInt($subNum);
        $subNumString = $subNum->number;
        
        $digitDifference = $this->length() - strlen($subNumString);
        for ($i = 0; $i < $digitDifference; $i++)
            $subNumString = '0'.$subNumString;

        $digitDifference = strlen($subNumString) - strlen($this->number);
        for ($i = 0; $i < $digitDifference; $i++)
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

        $this->clearLeadingZeros();
        return $this;
    }

    /**
     * @param BigInt|string|integer $divNum
     * @return BigInt
     */
    public function div($divNum)
    {
        if (is_numeric($divNum) || is_int($divNum))
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
            if ($next < $this->length())
                $now->rightPush($this->number[$next]);
            $next++;
            $now->clearLeadingZeros();
        } while($next <= $this->length());

        $this->number = $quotient->number;

        return $this;
    }

    /**
     * @param BigInt|string|integer $modNum
     * @return BigInt
     */
    public function mod($modNum)
    {
        if (is_numeric($modNum) || is_int($modNum))
            $modNum = new BigInt($modNum);
        if ($modNum->isBiggerThan($this))
            return $this;
        
        $now = new BigInt($this->number);
        $now->div($modNum);
        $now->clearLeadingZeros();
        $now->multiply($modNum);
        $this->sub($now);
        $this->clearLeadingZeros();

        return $this;
    }

    /**
     * @param BigInt|string|integer $multiplyNum
     * @return BigInt
     */
    public function multiply($multiplyNum)
    {
        if (is_numeric($multiplyNum) || is_int($multiplyNum))
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
        if (is_numeric($powNum) || is_int($powNum))
            $powNum = new BigInt($powNum);
        $this->powRecursive($powNum);
        return $this;
    }

    /**
     * @param BigInt $powNum
     * @return BigInt|BigNum
     */
    private function powRecursive($powNum)
    {
        if ($powNum->equals(0)) {
            $this->number = "1";
            return $this;
        }
        if ($powNum->equals(1))
            return $this;

        $powNumC = (new BigInt(''))->copy($powNum);
        $current = (new BigInt(''))->copy($this);
        $this->powRecursive($powNum->div(2));
        $this->multiply($this);
        if ($powNumC->mod(2)->equals(1))
            $this->multiply($current);
        
        return $this;
    }

    public function sqrt()
    {
        if ($this->number == '0')
            return $this;
        $result = '1';
        $left = new BigInt('0');
        $right = new BigInt($this->number);

        while ($left->equals($right) || $left->isLesserThan($right)) {
            $middle = new BigInt($left->number);
            $middle->add($right->number);
            $middle->div(2);
            $middle->clearLeadingZeros();
            $midSquared = new BigInt($middle->number);
            $midSquared->multiply($midSquared);
            if ($midSquared->equals($this)) {
                $result = $middle->number;
                break;
            } elseif ($midSquared->isLesserThan($this)) {
                $result = $middle->number;
                $left = new BigInt($middle->number);
                $left->add(1);
            } else {
                $right = new BigInt($middle->number);
                $right->sub(1);
            }
        }

        $this->number = $result;
        return $this;
    }

    /**
     * @return BigInt|BigNum
     */
    public function factorial()
    { 
        $this->number = $this->product(1, $this)->number;
        return $this;
    } 

    private function product($first_number, $last_number) : BigInt
    { 
        if (is_numeric($first_number) || is_int($first_number))
            $first_number = new BigInt($first_number);
        if (is_numeric($last_number) || is_int($last_number))
            $last_number = new BigInt($last_number);
        
        $difference = new BigInt($last_number);
        $difference->sub($first_number);

        $middle = new BigInt($last_number);
        $middle->add($first_number);
        $middle->div(2);

        $first_number_copy = new BigInt($first_number);

        $result = new BigInt(1);

        if ($difference->equals(0)) {
            return new BigInt(1);
        }

        if ($difference->equals(1)){
            $result->multiply($first_number_copy);
            $result->multiply($first_number_copy->add(1));
            return $result;
        } 

        if ($difference->equals(2)) 
        {
            $result->multiply($first_number_copy);
            $result->multiply($first_number_copy->add(1));
            $result->multiply($first_number_copy->add(1));
            return $result;
        }
        if ($difference->equals(3)) {
            $result->multiply($first_number_copy);
            $result->multiply($first_number_copy->add(1));
            $result->multiply($first_number_copy->add(1));
            $result->multiply($first_number_copy->add(1));
            return $result;
        } 

        if ($difference->isBiggerThan(3)) {
            $result->multiply($this->product($middle, $last_number));
            $middle->sub(1);
            $result->multiply($this->product($first_number, $middle));
            return $result; 
        }
    } 
}