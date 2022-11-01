<?php

namespace App\Actions\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateUser
{
    /**
     * @throws ValidationException
     */
    public function store(array $input): User
    {
        $this->validation($input);
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => $input['role'],
            'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function validation(array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ])->validate();
    }
}
