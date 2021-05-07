<?php

use Illuminate\Database\Seeder;

class InvitecodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\models\Invitecode::class,10)->create();
    }
}
