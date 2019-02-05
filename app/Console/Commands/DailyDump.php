<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Product;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class DailyDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump or update Data from remote server';

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
                    if($item[0] == null)
                        continue;
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
            Log::info('Successfully Dumped with new changes');
        }
        if($output == ""){            
            Log::info('There were no changes');
        }
        Log::info('Dump Cron executed');        
    }
}
