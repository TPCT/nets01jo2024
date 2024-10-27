<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qr_code = "https://nets3.page.link/?link=https://nets-project.tawajood.com/" . sha1(time()) . Str::random(10) . "&apn=com.dotjo.baddel&afl=https://nets-project.tawajood.com/" . sha1(time()) . Str::random(10) . "&isi=1667532660&ibi=jo.dot.Nets&ifl=https://nets-project.tawajood.com/&_imcp=1";

        return [
            'first_name'     => $this->faker->name(),
            'last_name'      => $this->faker->name(),
            'email'          => $this->faker->unique()->safeEmail(),
            'country_code'   => '+20',
            'phone'          => $this->faker->phoneNumber(),
            'street_name'    => $this->faker->address(),
            'image'          => '',
            'qr_code'        => $qr_code,
        ];
    }
}
