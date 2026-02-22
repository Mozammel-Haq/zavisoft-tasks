<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email'=>'hmojammel29@gmail.com'],
            [
                'name' => 'Mozammel Haq',
                'password' => Hash::make('admin')
            ]
        );

        // ensure a personal access client exists for the users provider
        $personal = Client::
            where('grant_types', 'like', '%personal_access%')
            ->where('provider', config('auth.guards.api.provider'))
            ->first();

        if (! $personal) {
            // call the passport:client command programmatically
            Artisan::call('passport:client', [
                '--personal' => true,
                '--name' => config('app.name'),
                '--provider' => config('auth.guards.api.provider'),
                '--no-interaction' => true,
            ]);
        }
    }
}
