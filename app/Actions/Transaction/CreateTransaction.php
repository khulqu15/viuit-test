<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateTransaction
{
    /**
     * @param array $input
     * @return Transaction
     * @throws ValidationException
     */
    public function store(array $input): Transaction
    {
        $this->validation($input);
        return Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $input['product_id'],
            'code' => Str::upper(Str::random(10)),
            'quantity' => $input['quantity'],
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function validation(array $input): void
    {
        Validator::make($input, [
            'quantity' => ['required', 'numeric'],
            'status' => ['nullable', 'string'],
        ])->validate();
    }
}
