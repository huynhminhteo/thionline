<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Model;

class CoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++){
            Model\Core::create([
                'name' => 'Kaiwa đợt '.$i,
                'date' => Carbon::now(),
            ]);
        }
    }
}
