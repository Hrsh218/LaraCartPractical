<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private $object;

    public function __construct(User $object)
    {
        $this->object = $object;
    }

    public function registration($inputs = null)
    {
        $user = $this->object->create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
            'phone_no' => $inputs['phone_no'],
            'status' => $inputs['status']
        ]);

        $user->assignRole('user');

        return $user;
    }

    public function login($inputs = null)
    {
        $user = $this->object->where('email', $inputs['email'])->first();

        if (!$user || !Hash::check($inputs['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }
        return $user;
    }

}
