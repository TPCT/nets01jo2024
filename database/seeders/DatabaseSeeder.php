<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(ClientSeeder::class);

        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(AboutUsSeeder::class);
        $this->call(SettingsSeeder::class);
//        $this->call(JobTitleSeeder::class);

    }
}
