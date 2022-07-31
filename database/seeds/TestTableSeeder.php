<?php

use Illuminate\Database\Seeder;
use App\Model;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($core = 1; $core <= 5; $core++){
            for($i = 1; $i <= 7; $i++){
                Model\Test::create([
                    'core_id' => $core,
                    'code' => 'M'.$i,
                    'stt' => $i,
                ]);
            }
        }
    }
}
