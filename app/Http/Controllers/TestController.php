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
                foreach ($data[0] as $item) {
                    $product = Product::find((string)$item[0]);
                    if($product == null){
                        $product = new Product;
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
                    else{
                        $product->description = $item[1];
                        $product->upc = $item[2];
                        $product->price = $item[3];
                        $product->availability = $item[4];
                        $product->total = $item[6];
                        $product->type = $item[7];
                        $product->brand = $item[8];
                        $product->save();
                    }
                }                
            }
        }
        if($output == ""){
            echo "false";
        }
    }
}
