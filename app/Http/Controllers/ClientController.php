<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(ClientService $clientService)
    {
        $this->middleware('auth');

        parent::__construct($clientService);
    }

    public function index()
    {
        $customers = $this->clientService->listCustomers();
        return view('welcome')->with(
            [ 'customers' => $customers ]
        );
    }

    public function show($id)
    {
        $customer = $this->clientService->getCustomerDetail($id);

        return view('detail')->with(
            [ 'customer' => $customer ]
        );
    }
}


