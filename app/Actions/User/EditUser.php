<?php

namespace App\Actions\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditUser
{
    /**
     * @param array $input
     * @param $user
     * @return mixed
     * @throws ValidationException
     */
    public function update(array $input, $user): mixed
    {
        $this->validation($input);
        $updates = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => $input['role'],
        ];
        if($input['password'])
            $updates['password'] = $input['password'];

        return User::find($user->id)->update($updates);
    }

    /**
     * @throws ValidationException
     */
    private function validation(array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string'],
        ])->validate();
    }
}
