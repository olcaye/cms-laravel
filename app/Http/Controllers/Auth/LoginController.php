<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use App\Services\ClientAuthenticationService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * The service to authenticate actions
     *
     * @var App\Services\clientAuthenticationService
     */
    protected $clientAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientAuthenticationService $clientAuthenticationService, ClientService $clientService)
    {
        $this->middleware('guest')->except('logout');

        $this->clientAuthenticationService = $clientAuthenticationService;

        parent::__construct($clientService);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {
            $tokenData = $this->clientAuthenticationService->getPasswordToken($request->input('email'), $request->input('password'));

            $userData = $this->clientService->getClientInformation();
            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user);

            return redirect()->route('home');
        } catch (ClientException $e) {
            $message = $e->getResponse()->getBody();

            if (Str::contains($message, 'invalid_credentials')) {
                $this->incrementLoginAttempts($request);
                return $this->sendFailedLoginResponse($request);
            }
            throw $e;
        }


    }

    public function registerOrUpdateUser($userData, $tokenData)
    {
        return User::updateOrCreate(
            [
                'client_id' => $userData->id,
            ],
            [
                'grant_type' => $tokenData->type,
                'access_token' => $tokenData->token,
                'token_expires_at' => $tokenData->expires_at,
            ]
        );
    }

    /**
     * Create a user session in the HTTP CLient
     * @return void
     */
    public function loginUser(User $user, $remember = true)
    {
        Auth::login($user, $remember);
        session()->regenerate();
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
