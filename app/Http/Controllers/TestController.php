<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Product;
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
                for($i=0;$i<5;$i++){
                    unset($data[0][$i]);
                }
                print_r($data);//exit;
                $product = new Product;
                foreach ($data[0] as $item) {
                    $product->sku = $item[0];
                    $product->description = $item[1];
                    $product->upc = $item[2];
                    $product->price = $item[3];
                    $product->availability = $item[4];
                    $product->total = $item[6];
                    $product->type = $item[7];
                    $product->brand = $item[8];
                    $product->save();
                }
                exit;
            }
        }
        if($output == ""){
            echo "false";
        }
    }
}
