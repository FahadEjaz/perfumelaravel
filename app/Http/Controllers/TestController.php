<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function test()
    {
        echo "<pre>";        
        $process = new Process(['./import.sh']);
        $process->setWorkingDirectory('/var/www/html/laravel.local');        
        $process->run();
        $output = $process->getOutput();    
        // executes after the command finishes
        if (!$process->isSuccessful()) {                        
            if (strpos($output, 'differ') !== false) {
                $data = Excel::toCollection(null, 'pricelist.xlsx', 'local');
                for($i=0;$i<4;$i++){
                    unset($data[0][$i]);
                }
                print_r($data);
            }
        }
        if($output == ""){
            echo "false";
        }
    }
}
