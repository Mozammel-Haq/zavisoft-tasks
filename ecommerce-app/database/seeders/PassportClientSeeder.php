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

        // Use updateOrCreate for the main Foodpanda client to maintain the same ID
        // and avoid "churning" the database, which breaks bookmarks/URLs.
        // We find by name because names are more stable than IDs in seeders.
        $client = Client::updateOrCreate(
            ['name' => 'Foodpanda App'],
            [
                'redirect_uris' => [$redirectUri],
                'grant_types'   => ['authorization_code', 'refresh_token', 'personal_access'],
                'provider'      => null,
                'revoked'       => false,
            ]
        );

        // If the client was just created and didn't have a secret, one was likely generated,
        // but it's good practice to ensure a secret exists for confidential clients.
        if (empty($client->secret)) {
            $client->update(['secret' => \Illuminate\Support\Str::random(40)]);
        }

        $this->command->info('Foodpanda OAuth client ensured/updated successfully.');
        $this->command->info('Client ID: ' . $client->id);
        $this->command->info('Redirect URI: ' . $redirectUri);
    }
}
