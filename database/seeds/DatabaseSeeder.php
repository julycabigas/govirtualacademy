<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\AccessLevel;
use App\Training;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        // User::create([
        // 		'name' => 'July Cabigas',
        // 		'email' => 'coolpardz@gmail.com',
        // 		'password' => Hash::make('cabigas'),
        // 		'role' => 1
        // ]);
        

        // Role::create([
        //         'name' => 'gold',
        //         'display_name' => 'Gold',
        //         'description' => 'Has access to 50% of the website\'s trainings'
        // ]);

        // Role::create([
        //         'name' => 'silver',
        //         'display_name' => 'Silver',
        //         'description' => 'Has access to 70% of the website\'s trainings'
        // ]);


        // Role::create([
        //         'name' => 'platinum',
        //         'display_name' => 'Platinum',
        //         'description' => 'Has access to all of the website\'s trainings'
        // ]);
        // 
        // AccessLevel::create([
        //     'name' => 'va',
        //     'display_name' => 'Virtual Assistant Training',
        // ]);


        Training::create([
            'access_id' => 1,
            'course_id' => 1
        ]);

        Training::create([
            'access_id' => 1,
            'course_id' => 2
        ]);

        Training::create([
            'access_id' => 1,
            'course_id' => 3
        ]);

    }
}
