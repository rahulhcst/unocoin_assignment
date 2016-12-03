<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @var array
     */
    private $sDetails;
    /**
     * @var array
     */
    private $subjects;

    /**
     * StudentController constructor.
     * @param array $studentDetails
     * @param array $subjects
     */
    public function __construct($studentDetails = [], $subjects = [])
    {
        $this->sDetails = $studentDetails;
        $this->subjects = $subjects;
    }

    /**
     * @param array $arr
     * @param int $leftIndex
     * @param int $rightIndex
     * @return mixed
     */
    private function partition (&$arr, $leftIndex, $rightIndex)
    {
        $pivot = $arr[($leftIndex+$rightIndex)/2]['total'];         //Selecting pivot

        while ($leftIndex <= $rightIndex)
        {
            while ($arr[$leftIndex]['total'] > $pivot)              //Increasing left index until it is smaller than pivot
                $leftIndex++;
            while ($arr[$rightIndex]['total'] < $pivot)             //Decreasing right index intil it is greater than pivot
                $rightIndex--;
            if ($leftIndex <= $rightIndex) {                        //Swap the values if left index is smaller then or equal to right index
                $tmp = $arr[$leftIndex];
                $arr[$leftIndex] = $arr[$rightIndex];
                $arr[$rightIndex] = $tmp;
                $leftIndex++;
                $rightIndex--;
            }
        }
        return $leftIndex;
    }

    /**
     * @param array $arr
     * @param int $leftIndex
     * @param int $rightIndex
     */
    private function quickSort(&$arr, $leftIndex, $rightIndex)
    {
        $index = $this->partition($arr,$leftIndex,$rightIndex);             //Calling partition function
        if ($leftIndex < $index - 1)
            $this->quickSort($arr, $leftIndex, $index - 1);                 //Recursive call to quicksort with new right index
        if ($index < $rightIndex)
            $this->quickSort($arr, $index, $rightIndex);                    //Recursive call to quicksort with new left index
    }

    /**
     * @param array $studentDetails
     * @param array $subjects
     * @return void
     */
    private function printOutput($studentDetails, $subjects)
    {
        echo "\r\n";
        $length = printf('%-10s|%-10s|', 'Rank', 'Name');               //Assigning output i.e., characters printed to length variable
        foreach ($subjects as $subject)
            $length += printf('%-10s|', $subject);
        $length += printf("%-10s\r\n", 'Total Marks');

        for ($i = 0; $i < $length; $i++)
            echo '_';

        echo "\r\n";

        foreach ($studentDetails as $k => $studentDetail) {
            printf('%-10s|%-10s|', $k+1, $studentDetail['name']);

            foreach ($studentDetail['marks'] as $v)
                printf('%-10s|', $v);
            printf('%-10s', $studentDetail['total']);
            echo "\r\n";
        }
    }

    /**
     *@return void
     */
    public function execute ()
    {
        $studenDetails = $this->sDetails;                       //Assigning class variable sDetails to local variable studentDetails
        $subjects = $this->subjects;                            //Assigning class variable subjects to local variable subjects
        $this->quickSort($studenDetails, 0, count($studenDetails)-1);           //Call to quickSort function for sorting on the basis of total marks in descending order
        $this->printOutput($studenDetails, $subjects);                          //Call to function for printing output
    }
}
