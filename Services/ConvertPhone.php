<?php
/**
 * Created by PhpStorm.
 * User: kuba
 * Date: 08.02.22
 */

namespace Services;

use Exception;

class ConvertPhone
{
    /**
     * Current convert text
     * @var string
     */
    protected $textToConvert;

    /**
     * @var array
     */
    protected $numericKeyboard = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz',
        0 => ' '
    ];

    public function __construct(){}

    /**
     * Sets the value currently convert text
     * @param $text
     */
    protected function setText($text){
        $textToConvert = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', strtolower($text));
        $this->textToConvert = $textToConvert;
    }

    /**
     * Return value currently convert text
     * @return string
     */
    protected function getText() {
        return $this->textToConvert;
    }

    /**
     * Return array with numeric and characters
     * @return array
     */
    protected function getNumericKeyboard (){
        return $this->numericKeyboard;
    }

    /**
     * Method checking single characters and return converted text
     * @param $text
     * @return string
     * @throws Exception
     */
    public function convertToNumeric($text)
    {

        if (!empty($text)) {
            $this->setText($text);
            $returnNumber = '';
            foreach (str_split($this->getText()) as $character){
                $returnNumber .= (string)$this->characterConvertToNumber($character);
            }
            return $returnNumber;

        } else {
            throw new Exception('Brak teksu do zmiany');
        }
    }

    /**
     * Convert character to digit
     * @param $character
     * @return string
     */
    protected function characterConvertToNumber($character)
    {
        foreach ($this->getNumericKeyboard() as $number => $characters){
            if(strpos($characters, $character) !== false){
                $count = strpos($characters, $character);
                return $this->getConvertedNumber($count +1, $number);
            }
        }

        return '';
    }

    /**
     * Convert character to number x times pressed
     * @param $count
     * @param $number
     * @return string
     */
    protected function getConvertedNumber($count, $number){
        $convertedCharacter = '';
        for ($i=0; $i < $count; $i++){
            $convertedCharacter .= (string)$number;
        }
        return $convertedCharacter;
    }
    
}
