<?php

namespace App\Http\Controllers;

use App\Domains\Auth\Requests\LoginRequest;
use App\Features\LoginFeature;
use Lucid\Units\Controller;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->serve(LoginFeature::class);
    }
}
