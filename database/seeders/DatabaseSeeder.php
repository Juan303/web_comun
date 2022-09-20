<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Usuario;
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
        Admin::create([
            'name' => 'CSnet',
            'email' => 'web@csnet.es',
            'email_verified_at' => date('Y-m-d H:i:s' , time()),
            'password' => bcrypt('csnet2022')
        ]);

        Usuario::create([
            'name' => 'CSnet',
            'email' => 'web@csnet.es',
            'email_verified_at' => date('Y-m-d H:i:s' , time()),
            'Estado' => true,
            'password' => bcrypt('csnet2022')
        ]);
    }
}
