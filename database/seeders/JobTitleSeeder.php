<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobTitle::create([
            'ar' => [
                'name' => 'دكتور'
            ],
            'en' => [
                'name' => 'Doctor'
            ]
        ]);
        JobTitle::create([
            'ar' => [
                'name' => 'مدرس'
            ],
            'en' => [
                'name' => 'Teacher'
            ]
        ]);

    } // end of run

}
