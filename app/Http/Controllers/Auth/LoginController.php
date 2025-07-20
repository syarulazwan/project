<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected $service;

    public function __construct(LoginService $service) {

        $this->service = $service;

    }

    public function index() {

        if (auth()->check()) {

            return redirect()->route('dashboard');

        }

        return view('auth.login'); 

    }

   public function store(LoginRequest $request)
    {
        $token = $this->service->login($request->validated());

        if (!$token) {
            return redirect()->back()
                ->withErrors([
                    'error_message' => 'Invalid credentials'
                ])
                ->withInput() 
                ->with([
                    'email_value' => $request->email,
                    'password_value' => $request->password,

                ],);
        }

        return redirect()->route('dashboard');
    }

}
