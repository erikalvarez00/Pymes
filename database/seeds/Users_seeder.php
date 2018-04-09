<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Users;

class Users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $faker = Faker\Factory::create();

        for ($i=0; $i < 100; $i++) { 
        	# code...

                DB::table('users')->insert([

        		'nombre' => $faker->firstName,
        		'apellidoM' => $faker->lastName,
        		'apellidoP' => $faker->lastName,
        		'email' => $faker->email,
        		'password' => $faker->password,
                'equipo' => $faker->randomElement($array = array('Pymes','Software','Civil','Ambiental','Manofactura','Telematica')),
        		'id_role' => $faker->randomElement($array = array ('1','2','3')),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()


        	 ]);
        }

    }
}
