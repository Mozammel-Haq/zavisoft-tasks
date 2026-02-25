<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportClientSeeder extends Seeder
{
    public function run(): void
    {
        $foodpandaUrl = env('FOODPANDA_URL', 'https://zavi-foodpanda.up.railway.app');
        $redirectUri  = $foodpandaUrl . '/auth/callback';

        // Foodpanda client setup
        $client = Client::updateOrCreate(
            ['name' => 'Foodpanda App'],
            [
                'redirect_uris' => [$redirectUri],
                'grant_types'   => ['authorization_code', 'refresh_token', 'personal_access'],
                'provider'      => null,
                'revoked'       => false,
            ]
        );

        // Ensure client secret exists
        if (empty($client->secret)) {
            $client->update(['secret' => \Illuminate\Support\Str::random(40)]);
        }

        $this->command->info('Foodpanda OAuth client ensured/updated successfully.');
        $this->command->info('Client ID: ' . $client->id);
        $this->command->info('Redirect URI: ' . $redirectUri);
    }
}
