<?php

namespace App\Models\Passport;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    /**
     * Interact with the client's redirect URIs.
     */
    protected function redirectUris(): Attribute
    {
        return Attribute::make(
            get: function (?string $value, array $attributes): array {
                // If the value is valid JSON, decode it
                if (!empty($value)) {
                    $json = json_decode($value, true);
                    if (is_array($json)) {
                        return $json;
                    }
                    // If it wasn't JSON but was a string (e.g. a raw URL), wrap it in an array
                    return [$value];
                }

                // Compatibility with older Passport 'redirect' column if it exists in attributes
                if (!empty($attributes['redirect'])) {
                    return explode(',', $attributes['redirect']);
                }

                return [];
            }
        );
    }

    /**
     * Interact with the client's grant types.
     */
    protected function grantTypes(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): array {
                if (isset($value)) {
                    $json = json_decode($value, true);
                    if (is_array($json)) {
                        return $json;
                    }
                    // Fallback for raw string
                    return explode(',', $value);
                }

                // Default Passport logic if value is null
                return array_keys(array_filter([
                    'authorization_code' => ! empty($this->redirect_uris),
                    'client_credentials' => $this->confidential() && $this->firstParty(),
                    'implicit' => ! empty($this->redirect_uris),
                    'password' => $this->password_client,
                    'personal_access' => $this->personal_access_client && $this->confidential(),
                    'refresh_token' => true,
                    'urn:ietf:params:oauth:grant-type:device_code' => true,
                ]));
            }
        );
    }
}
