<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use App\Traits\HandleClientResponses;
use Illuminate\Support\Carbon;

class ClientAuthenticationService {
    use ConsumesExternalServices, HandleClientResponses;

    /**
     * The URL to send the requests
     * @var string
     */
    protected string $baseUri;

    /**
     * The client id to identify the client in the API
     * @var string
     */
    protected mixed $clientId;

    /**
     * The client token to identify the client in the API
     * @var string
     */
    protected mixed $clientToken;

    public function __construct()
    {
        $this->baseUri = config('services.client.base_uri');
        $this->clientId = config('services.client.id');
        $this->clientToken = config('services.client.token');
    }


    public function getPasswordToken($email = 'olcayergul@msn.com', $password = '0000006')
    {
        $formParams = [
            'grant_type' => 'bearer',
            'email' => $email,
            'password' => $password,
        ];

        $tokenData = $this->makeRequest('POST', 'client/login', [], $formParams);

        $this->storeValidToken($tokenData, 'bearer');

        return $tokenData;
    }

    /**
     * Stores a valid token with some attributes
     * @return void
     */
    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = Carbon::parse($tokenData->expires_at);
        $tokenData->access_token = "{$tokenData->type} {$tokenData->token}";
        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData]);
    }

    /**
     * Verify if there is any valid token on session
     * @return string\boolean
     */
    public function existingValidToken()
    {
        if (session()->has('current_token')) {
            $tokenData = session()->get('current_token');

            if (Carbon::now()->gt($tokenData->token_expires_at)) {
                return $tokenData->access_token;
            }
        }

         return false;
    }
}
