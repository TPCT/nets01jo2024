<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AboutUs::create([
            'ar' => [
                'description'  => 'معلومات عنا'
            ],
            'en' => [
                'description'  => 'About Us'
            ]
        ]);
    }
}
