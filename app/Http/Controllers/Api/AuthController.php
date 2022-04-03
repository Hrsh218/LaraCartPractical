<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ApiResponser;
use App\Http\Requests\Auth\login;
use App\Http\Requests\Auth\registration;
use Illuminate\Http\Request;
use App\Http\Resources\Auth\Resource as UserResource;

class AuthController extends Controller
{
    use ApiResponser;
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function registration(registration $request)
    {
        $user = $this->service->registration($request->all());
        $data = [
            'user' => new UserResource($user),
            'token' => $user->createToken(config('app.name'))->plainTextToken
        ];
        return $this->success($data, 200);
    }

    public function logIn(login $request)
    {
        $user = $this->service->login($request->all());
        $data = [
            'user' => new UserResource($user),
            'token' => $user->createToken(config('app.name'))->plainTextToken
        ];
        return $this->success($data, 200);
    }

    public function logOut(Request $request) {

        $logout = $request->user()->currentAccessToken()->delete();

        if($logout == true)
        {
            $data['message'] = __('validation.logout');
            return $data;
        }
    }
}

