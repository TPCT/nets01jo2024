<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'ar' => [
                'terms_and_conditions' => 'الشروط والاحكام',
                'privacy_policy'       => 'سياسة الخصوصية',
            ],
            'en' => [
                'terms_and_conditions' => 'Terms and Conditions',
                'privacy_policy'       => 'Privacy Policy'
            ]
        ]);
    }
}
