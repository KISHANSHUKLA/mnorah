<?php

namespace App\Console\Commands;

use App\models\Api\limit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class limitcheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limitcheck:run';

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
        Log::info("Cron is working fine!");
     
        $limits = limit::get(); 
        
        foreach( $limits as $limit ) {
            $limitSave = limit::find($limit->id);
            $limitSave->forgot_password =  0;
            $limitSave->opt =  0;
            $limitSave->save();
      }  
      
      $this->info('limit upgrade successfully');
    }
}
