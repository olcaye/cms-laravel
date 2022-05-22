<?php

namespace App\Services;

use App\Traits\AuthorizesClientRequests;
use App\Traits\ConsumesExternalServices;
use App\Traits\HandleClientResponses;

class ClientService {
    use ConsumesExternalServices, AuthorizesClientRequests, HandleClientResponses;

    protected string $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.client.base_uri');
    }

    public function listCustomers() {
        return $this->makeRequest('GET', 'customers');
    }

    public function getCustomerDetail($id) {

        return $this->makeRequest('GET', 'customers/' . $id);
    }


    public function getClientInformation()
    {
        return $this->makeRequest('GET', 'client');
    }

}
