<?php

namespace TH\String;

class Palindrom
{
    private $originalStr;
    private $prepareStr;
    private $length;

    private $maxPalindrom;
    private $evenPalindrom;
    private $oddPalindrom;

    private function setStr($str)
    {
        $this->originalStr = $str;
        $this->prepareStr = mb_strtolower(str_replace(' ', '', $this->originalStr));
        $this->length = mb_strlen($this->prepareStr);
    }

    private function getChar($idx)
    {
        return mb_substr($this->prepareStr, $idx, 1);
    }

    private function compareChars($idx1, $idx2)
    {
        return strcmp($this->getChar($idx1), $this->getChar($idx2)) == 0;
    }

    /**
     * Ищем максимальный четный палиндром
     */
    private function findEvenPalindrom()
    {
        $this->evenPalindrom = '';

        for ($leftIdxByEvenPalindrom = 0; $leftIdxByEvenPalindrom < $this->length; $leftIdxByEvenPalindrom++) {
            $findPalindrom = '';
            $leftIdx = $leftIdxByEvenPalindrom;
            $rightIdx = $leftIdxByEvenPalindrom + 1;
            while ($leftIdx >= 0 && $rightIdx < $this->length && $this->compareChars($leftIdx, $rightIdx)) {
                $findPalindrom = $this->getChar($leftIdx) . $findPalindrom . $this->getChar($rightIdx);
                $leftIdx--;
                $rightIdx++;
            }

            if (mb_strlen($this->evenPalindrom) < mb_strlen($findPalindrom)) {
                $this->evenPalindrom = $findPalindrom;
            }
        }
    }

    /**
     * Ищем максимальный нечетный палиндром
     */
    private function findOddPalindrom()
    {
        $this->oddPalindrom = '';

        for ($centerOfOddPalindrom = 0; $centerOfOddPalindrom < $this->length; $centerOfOddPalindrom++) {
            $findPalindrom = '';
            $leftIdx = $centerOfOddPalindrom - 1;
            $rightIdx = $centerOfOddPalindrom + 1;
            while ($leftIdx >= 0 && $rightIdx < $this->length && $this->compareChars($leftIdx, $rightIdx)) {
                if ($findPalindrom == '') {
                    $findPalindrom = $this->getChar($centerOfOddPalindrom);
                }
                $findPalindrom = $this->getChar($leftIdx) . $findPalindrom . $this->getChar($rightIdx);
                $leftIdx--;
                $rightIdx++;
            }

            if (mb_strlen($this->oddPalindrom) < mb_strlen($findPalindrom)) {
                $this->oddPalindrom = $findPalindrom;
            }
        }
    }

    private function find()
    {
        $this->findEvenPalindrom();
        $this->findOddPalindrom();
        $this->maxPalindrom = mb_strlen($this->evenPalindrom) > mb_strlen($this->oddPalindrom) ? $this->evenPalindrom : $this->oddPalindrom;
    }

    /**
     * Ищем максимальный палиндром и выводим результат
     * всю строку - если исходная строка палиндром
     * максимальный подпалиндром, который мы сумели найти внутри исходной строки
     * первый символ исходной строки, если палиндромов не было найдено
     *
     * @param $str - исходная строка, в которой необзодимо найти самый длинный палиндром
     */
    public function printResult($str)
    {
        $this->setStr($str);
        $this->find();

        if (strcmp($this->maxPalindrom, $this->prepareStr) == 0) {
            echo $this->originalStr;
        } else if ($this->maxPalindrom != '') {
            echo $this->maxPalindrom;
        } else {
            echo mb_substr($this->originalStr, 0, 1);
        }

        echo '<br>';
    }

}