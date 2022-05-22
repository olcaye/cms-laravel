<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The client service to consume from this client
     * @var App\Service\ClientService
     */
    protected $clientService;

    public function __construct(ClientService $clientService) {
        $this->clientService = $clientService;
    }
}
