<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\ForgotPasswordService;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    protected $service;

    public function __construct(ForgotPasswordService $service) {

        $this->service = $service;

    }

    public function index() {

        return view('auth.forgot-password'); 

    }

    public function store(ForgotPasswordRequest $request) {

        $resetPassword = $this->service->resetPassword($request->validated());

        if (!$resetPassword) {
            return back()
            ->withErrors(['error_message' => 'Email not found or failed to send reset link'])
            ->with([
                    'email_value' => $request->email,
                    'password_value' => $request->password,
                    'password_confirmation_value' => $request->password_confirmation,
                ],);
        }

        return redirect()->route('login.form')->with('success', 'Password reset link sent!');;
    }
}
