<?php

namespace hpez\bignum;

class BigFloat extends BigNum
{
    public function __construct(
        $number
    ) {
        $this->number = (string)$number;

        if (strpos($this->number, '.') === false) {
            $this->number = $this->number . '.0';
        }

        parent::__construct($this->number);
    }

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
        return $this->length() - $this->intLength() - 1;
    }

    /**
     * @param BigFloat|string|double $addNum
     * @return BigFloat
     */
    public function add($addNum)
    {
        if (is_numeric($addNum) || is_double($addNum))
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
        if (is_numeric($subNum) || is_double($subNum))
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

    /**
     * @param BigFloat|string|double $multiplyNum
     * @return BigFloat
     */
    public function multiply($multiplyNum)
    {
        if (is_numeric($multiplyNum) || is_double($multiplyNum))
            $multiplyNum = new BigFloat($multiplyNum);

        $precisionCount = $this->decLength() + $multiplyNum->decLength();

        $firstInt = new BigInt(str_replace('.', '', $this->number));
        $firstInt->multiply(str_replace('.', '', $multiplyNum->number));

        return new BigFloat(substr($firstInt->number, 0, $firstInt->length() - $precisionCount).'.'
            .substr($firstInt->number,$firstInt->length() - $precisionCount, $precisionCount));
    }

    /**
     * @param BigFloat|string|double $divNum
     * @param int $precision
     * @return BigFloat
     */
    public function div($divNum, $precision = 6)
    {
        if (is_numeric($divNum) || is_double($divNum))
            $divNum = new BigFloat($divNum);

        ++$precision;

        $precisionCount = $this->decLength() - $divNum->decLength();

        for ($i = 0; $i < $precision - $precisionCount; $i++)
            $this->rightPush('0');

        $firstInt = new BigInt(str_replace('.', '', $this->number));
        $firstInt->div(str_replace('.', '', $divNum->number));

        $lastIndex = strlen($firstInt->number) - 1;
        $last = (int) $firstInt->number[
            $lastIndex
        ];
        if ($last >= 5) {
            $number = (int) $firstInt->number[$lastIndex-1];
            ++$number;
            $firstInt->number[$lastIndex-1] = $number;
        }

        return new BigFloat(substr($firstInt->number, 0, $firstInt->length() - $precision).'.'
            .substr($firstInt->number,$firstInt->length() - $precision, $precision - 1));
    }

    /**
     * @param int $precision = 6
     * @return BigFloat
     */
    public function sqrt(int $precision = 6): BigFloat
    {
        $nextAttempt = clone $this;

        do
        {
            $previousAttempt = $nextAttempt;
            $testable = clone $previousAttempt;

            $nextAttempt = $previousAttempt->sub(
                $previousAttempt
                ->multiply(clone $previousAttempt)
                ->sub($this)
                ->div(
                    ($previousAttempt)->multiply(2),
                    $precision
                )
            );
            $nextAttempt->clearLeadingZeros();
        } while (!$nextAttempt->equals($testable));

        return $nextAttempt;
    }

    /**
     * @param BigInt|string|integer $powNum
     * @return BigFloat
     */
    public function pow($powNum)
    {
        if (is_numeric($powNum) || is_int($powNum))
            $powNum = new BigInt($powNum);
        
        $numOfDecimalPlaces = (new BigInt($this->countNumOfDecimalPlaces()))->multiply($powNum);
        $numNoDecimalPoint = $this->removeDecPoints();

        $baseNum = (new BigInt($numNoDecimalPoint))->pow($powNum);
        $this->copy($baseNum);

        $this->addDecimalPoint($numOfDecimalPlaces);

        return $this;
    }

    /**
     * @return int
     */
    private function countNumOfDecimalPlaces()
    {
        $decimalPointPos = stripos($this->number, '.');
        $decimalNumPart = substr($this->number, $decimalPointPos + 1);
        return strlen($decimalNumPart);
    }

    /**
     * @return string
     */
    private function removeDecPoints()
    {
        return str_replace('.', '', $this->number);
    }

    /**
     * @param BigInt|string|integer $numOfDecimalPlaces
     * @return BigNum
     */
    private function addDecimalPoint($numOfDecimalPlaces)
    {
        $wholeNumberPart = substr($this->number, 0, -$numOfDecimalPlaces->number);
        if (strlen($wholeNumberPart) == 0)
            $wholeNumberPart = '0';

        $decimalPlacesPart = substr($this->number, -$numOfDecimalPlaces->number);
        
        $decimalPlacesPartLen = strlen($decimalPlacesPart);
        $numOfDecimalPlacesLen = (int) $numOfDecimalPlaces->number;
        if ($decimalPlacesPartLen != $numOfDecimalPlacesLen) {
            $decPlacesDiff = $numOfDecimalPlacesLen - $decimalPlacesPartLen;
            $decimalPlacesPart = str_repeat('0', $decPlacesDiff) . $decimalPlacesPart;
        }

        $this->number =  $wholeNumberPart.'.'.$decimalPlacesPart;             

        return $this;
    }
}