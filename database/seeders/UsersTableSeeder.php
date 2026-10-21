<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** Default administrator account for a new or existing database. */
class UsersTableSeeder extends Seeder
{
    public const USERNAME = 'administrator';
    public const DEFAULT_PASSWORD = 'password123';

    public function run()
    {
        $user = User::whereRaw('LOWER(username) = ?', [self::USERNAME])->first();
        $user ??= new User(['gender' => 'Male']);

        $user->fill([
            'fname' => 'Jophed',
            'mname' => '',
            'lname' => 'Abril',
            'username' => self::USERNAME,
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'role' => 'Administrator',
            'access' => implode(',', array_fill(0, count(User::MODULES), '1')),
        ]);
        $user->remember_token ??= Str::random(10);
        $user->save();

        $this->command?->info('Administrator account seeded. Change the default password after signing in.');
    }
}
