<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        $this->call(UserTableSeeder::class);
        $this->call(CoreTableSeeder::class);
        $this->call(TestTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
    }
}
