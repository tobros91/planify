<?php

use App\User;
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
        factory(App\User::class)->create([
            'name' => 'Tobias Rosengren',
            'email' => 'tobias@bechwebb.se',
            'password' => bcrypt('testar')
        ]);

        factory(App\User::class)->create([
            'name' => 'Tobias Tråkengren',
            'email' => 'tobias@tobiasrosengren.se',
            'password' => bcrypt('testar')
        ]);

        $this->call(ProjectsTableSeeder::class);
    }
}
