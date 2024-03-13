<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::create('now');

        for ($i=1; $i<=10; $i++) {
            DB::table('tasks')->insert([
                'description' => 'Lorem ipsum dolor sit amet.',
                'userId' => User::all()->random()->id,
                'estimatedTime' => rand(1,100),
                'usedTime' => rand(1,100),
                'created_at' => $date->subDays(rand(20, 30))->format('Y-m-d H:i:s'),
                // 'completedAt' => $date->subDays(rand(1, 10))->format('Y-m-d H:i:s'),
                'done' => rand(0,1)
            ]);
        }
    }
}
