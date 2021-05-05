<?php

use Illuminate\Database\Seeder;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        factory(App\User::class, 10)->create();
        factory(App\models\Church::class, 10)->create();
    }
}
