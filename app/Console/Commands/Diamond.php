<?php

namespace App\Console\Commands;

use App\Http\Controllers\DiamondController;
use Illuminate\Console\Command;

class Diamond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'diamond';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Diamond constructor.
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
        $rows = $this->ask('Enter number of rows', 0);          //For taking input from the user, number of rows
        $rows = (int)$rows;                                     //Type casting to integer

        if ($rows < 0)                                          //Validation input is a positive integer
            die("Invalid input please enter positive integer");

        $diamondObj = new DiamondController($rows);             //Instantiating class DiamondController, passing number of rows to the constructor
        $diamondObj->printPattern();                            //Function call for printing pattern
    }
}
