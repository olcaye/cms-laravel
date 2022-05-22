<?php

namespace App\Traits;

use App\Services\ClientAuthenticationService;

trait AuthorizesClientRequests
{
    /**
     * Resolve the elements to send when authorizing the request
     * @return void
     */
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken->token,
            'Accept'        => 'application/json',
        ];

    }


    public function resolveAccessToken() {
        $authenticationService = resolve(ClientAuthenticationService::class);
        return $authenticationService->getPasswordToken();
    }
}
