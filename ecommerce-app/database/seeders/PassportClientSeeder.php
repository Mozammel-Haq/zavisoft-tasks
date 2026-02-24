<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportClientSeeder extends Seeder
{
    public function run(): void
    {
        $foodpandaUrl = env('FOODPANDA_URL', 'https://placeholder.railway.app');
        $redirectUri  = $foodpandaUrl . '/auth/callback';

        // Check if Foodpanda client already exists
        $exists = Client::where('name', 'Foodpanda App')
            ->where('redirect_uris', $redirectUri)
            ->exists();

        if ($exists) {
            $this->command->info('Foodpanda OAuth client already exists — skipping.');
            return;
        }

        // Remove any old Foodpanda clients to avoid duplicates
        Client::where('name', 'Foodpanda App')->delete();

        // Create new client
        $client = Client::create([
            'name'          => 'Foodpanda App',
            'secret'        => \Illuminate\Support\Str::random(40),
            // store JSON arrays so Passport's attribute casts/closures return arrays
            'redirect_uris' => json_encode([$redirectUri]),
            'grant_types'   => json_encode([]),
            'provider'      => null,
            'revoked'       => false,
        ]);

        $this->command->info('Foodpanda OAuth client created successfully.');
        $this->command->info('Client ID: ' . $client->id);
        $this->command->info('Client Secret: ' . $client->secret);
        $this->command->info('Redirect URI: ' . $redirectUri);
    }
}
