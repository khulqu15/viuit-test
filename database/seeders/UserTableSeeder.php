<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@viuit.id';
        $user->email_verified_at = Carbon::now()->timestamp;
        $user->password = 'password';
        $user->role = 'guest';
        $user->save();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@viuit.id';
        $admin->email_verified_at = Carbon::now()->timestamp;
        $admin->password = 'password';
        $admin->role = 'admin';
        $admin->save();
    }
}
