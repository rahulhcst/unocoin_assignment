<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiamondController extends Controller
{
    /**
     * @var $rows
     */
    private $rows;

    /**
     * DiamondController constructor.
     * @param $nor
     */
    public function __construct($nor)
    {
        $this->rows = $nor;
    }

    /**
     * @param $nos
     * @return string
     */
    private function addSpaces($nos)
    {
        $spaceString = '';
        for ($i = 1; $i <= $nos; $i++)
            $spaceString .= ' ';
        return $spaceString;
    }

    /**
     * @param $nos
     * @return string
     */
    private function addMirrorSpaces($nos)
    {
        $spaceString = ' ';
        for ($i = 1; $i <= $nos; $i++)
            $spaceString .= '  ';
        return $spaceString;
    }

    /**
     * @param string $string
     * @param int $length
     * @param string $append
     * @return bool|string
     */
    private function append ($string, $length, $append)                 //Function appends character to string
    {
        if (strlen($string) < $length) {                                //Checks if string can accomodate a new character
            $temp = $string.$append;
            if (strlen($temp) <= $length){
                return $temp;
            } else
                return false;
        }
        return false;
    }

    /**
     * @return void
     */
    public function printPattern ()
    {
        $rows = $this->rows;
        $midRow = (int)ceil($rows/2);           //Middle row

        $a = 0;
        $b = 1;

        $space = $midRow-1;                    //Number of space characters
        $prev = false;

        $unoText = 'UNOCOIN';

        $v = 0;

        for ($i = 1; $i <= $rows; $i++) {     //Loop iterates on the total number of rows
            $spaceRow = '';
            $rowString = '';
            $mpSpaceRow = '';
            $text = '';

            if ($i <= $midRow) {                        //For upper part of diamond
                $spaceRow = $this->addSpaces($space);                       //Appending space in starting of each row
                $mpSpaceRow = $this->addMirrorSpaces($space);               //Appending space for mirror diamond

                $space--;
                $limit = 2 * $i -1;
            } elseif ($rows % 2 == 0 && $i == ($midRow + 1)) {              //If number of rows is even
                $v = 1;
                $mpSpaceRow = $this->addSpaces(1);
            } elseif ($i > $midRow) {                                       //For lower part of diamond
                if ($space < 1)
                    $space = 1;

                /*for ($j = 1; $j <= $space; $j++) {
                    $spaceRow .= ' ';                                       //Appending space in starting of each row
                    $mpSpaceRow .= '  ';                                    //Appending space for mirror diamond
                }*/
                $spaceRow = $this->addSpaces($space);
                $mpSpaceRow = $this->addMirrorSpaces($space);

                $limit = $rows-($space*2 + $v);
                $space++;
            }

            for ($j = 1; $j <= $limit; $j++) {                              //Appending charcters to each row
                if ($prev) {
                    $insert = $prev;
                    $prev = false;
                } else {
                    $temp = $a;
                    $a = $b;
                    $b += $temp;
                    $insert = (string)$a;
                }

                if (strlen($text) < $limit) {                               //For the text UNOCOIN
                    for ($k = 0; $k < strlen($unoText); $k++) {
                        $appResult = $this->append($text, $limit, $unoText[$k]);
                        if ($appResult)
                            $text = $appResult;
                        else
                            break;
                    }
                }

                if (strlen($insert) > 1) {                                  //If the inserted string length is greatet then 1
                    $str = (string)$insert;
                    for ($k = 0; $k < strlen($str); $k++) {
                        $appResult = $this->append($rowString, $limit, $str[$k]);               //Appending character of string one by one
                        if (!$appResult) {                                                      //Checking the result returned of append
                            $prev = substr($str, $k);
                            break;
                        }
                        $rowString = $appResult;
                    }
                } else {
                    $appResult = $this->append($rowString, $limit, $insert);                    //Appending single character
                    if (!$appResult)                                                            //Checking the result returned of append
                        break;
                    $rowString = $appResult;
                }

                $appResult = $this->append($rowString, $limit, '+');                           //Appending '+' to string
                if (!$appResult)
                    break;
                $rowString = $appResult;
            }       //for $j
            echo "$spaceRow$rowString$mpSpaceRow$text\r\n";                     //Printing the output row after appending
        }           //for $i
    }

}
