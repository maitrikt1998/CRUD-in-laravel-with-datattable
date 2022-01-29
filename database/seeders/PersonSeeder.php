<?php

namespace Database\Seeders;
use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        for($i=1;$i<=100;$i++){
            person::create([
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'email' => $faker->safeEmail,
                'gender' => $faker->randomElement(["male", "female"]),
                // 'stream' => 'Physics',
            ]);
        }
        
    }
}
