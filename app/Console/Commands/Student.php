<?php

namespace App\Console\Commands;

use App\Http\Controllers\StudentController;
use Illuminate\Console\Command;

class Student extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $return = true;

        $studentDetails = [];           //Arrays storing student details (student name, marks of each subject, total marks)

        $students = [];                 //Array having students name
        $subjects = [];                 //Array having subjects name

        while ($return) {
            $input = $this->ask('Enter name of STUDENT or LEAVE BLANK and hit return to exit', false);          //Reading input students name entered by user
            if ($input)
                array_push($students, $input);
            else
                $return = false;
        }

        echo "------------------------------------------------------------\r\n";
        $return = true;
        while ($return) {
            $input = $this->ask('Enter name of SUBJECTS or LEAVE BLANK and hit return to exit', false);         //Reading input subjects name entered by user
            if ($input)
                array_push($subjects, $input);
            else
                $return = false;
        }

        echo "------------------------------------------------------------\r\n";
        /*
         * For taking marks of each student for each subject
         */
        foreach ($students as $student) {                           //Iterating over students array
            $details = [];                                          //Array for storing student's detail
            echo "Enter marks for student $student:\r\n";
            $details['name'] = $student;                            //Assigning student name
            $details['marks'] = [];                                 //Array for storing student's marks for each subject
            $details['total'] = 0;                                  //For storing totral marks, initialising with 0
            foreach ($subjects as $subject) {
                $marks = $this->ask('Enter marks of '.$subject, false);         //Input for taking marks from user of each subject
                if (!$marks)
                    $marks = 0;                                                 //If marks is not enterd assuming 0
                array_push($details['marks'], $marks);                          //Pushing marks into $details['marks'] array
                $details['total'] += $marks;                                    //Taking sum of the marks
            }
            array_push($studentDetails, $details);                              //Pushin details into array $studentDetails
        }

        $studentObj = new StudentController($studentDetails, $subjects);        //Instantiating class StudentController and passing array studentDetails, $subjects
        $studentObj->generateResult();                                                 //Calling function execute
    }
}
