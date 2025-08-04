<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\RegistrationService;
use App\Http\Requests\Auth\RegistrationRequest;

class RegistrationController extends Controller
{

    protected $service;

    public function __construct(RegistrationService $registrationService) {

        $this->registrationService = $registrationService;

    }

    public function index() {

        return view('auth.sign-up'); 

    }

    public function store(RegistrationRequest $request)
    {
        $user = $this->registrationService->register($request->validated());

        if (!$user) {
            return redirect()->back()
                ->withErrors(['error_message' => 'Registration failed'])
                 ->with([
                    'name_value' => $request->name,
                    'email_value' => $request->email,
                    'password_value' => $request->password,
                    'password_confirmation_value' => $request->password_confirmation,
                ],);
        }

        return redirect()->route('login.form')->with('success', 'Account successfully created. Please login.');;
    }

}
