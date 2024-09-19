<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Enums\UserRole;

final class UserSeeder extends Seeder
{

    private const USERS = [
        ['email' => 'admin@example.com', 'name' => 'Administrator'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (self::USERS as $user) {
            User::factory()
                    ->for(Company::first())
                    ->create([
                        'email' => $user['email'],
                        'name' => $user['name'],
                        'password' => 'qwerty1234',
                        'role' => UserRole::ADMINISTRATOR,
            ]);
        }

        Company::all()->each(static fn(Company $company) =>
                        User::factory(random_int(1, 5))
                        ->for($company)
                        ->create([
                            'password' => 'qwerty1234',
                        ])
        );
    }
}
