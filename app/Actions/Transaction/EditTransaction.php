<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EditTransaction
{
    /**
     * @param array $input
     * @param $id
     * @return mixed
     * @throws ValidationException
     */
    public function update(array $input, $transaction): mixed
    {
        $this->validation($input);
        $updates = [
            'quantity' => $input['quantity'],
            'status' => $input['status'],
        ];
        if($input['verified_at']) {
            $updates['verified_at'] = Carbon::now()->toDateTimeString();
        }
        return Transaction::find($transaction->id)->update($updates);
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
