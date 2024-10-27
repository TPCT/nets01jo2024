<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'ar' => [
                'name' => 'القاهرة'
            ],
            'en' => [
                'name' => 'cairo'
            ],
            'country_id' => 53,
        ]);
         city::create([
            'ar' => [
                'name' => 'الاسكندرية'
            ],
            'en' => [
                'name' => 'Alex'
            ],
            'country_id' => 53,
        ]);

       City::create([
            'ar' => [
                'name' => 'الرياض'
            ],
            'en' => [
                'name' => 'Riyadh'
            ],
            'country_id' => 149,

        ]);
        city::create([
            'ar' => [
                'name' => 'المدينة'
            ],
            'en' => [
                'name' => 'Medina'
            ],
            'country_id' => 149,
        ]);
        city::create([
            'ar' => [
                'name' => 'مكه'
            ],
            'en' => [
                'name' => 'Mecca'
            ],
            'country_id' => 149,
        ]);
        city::create([
            'ar' => [
                'name' => 'عمان'
            ],
            'en' => [
                'name' => 'Amman'
            ],
            'country_id' => 84,
        ]);
        city::create([
            'ar' => [
                'name' => 'غزة'
            ],
            'en' => [
                'name' => 'Gaza'
            ],
            'country_id' => 1,
        ]);

    } // end of run
}
