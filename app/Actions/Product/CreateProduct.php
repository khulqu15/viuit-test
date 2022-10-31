<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateProduct
{
    public function store(array $input): Product
    {
        return Product::create([
            'user_id' => Auth::id(),
            'name' => $input['name'],
            'price' => $input['price'],
            'description' => $input['description'],
            'photo' => $input['photoname'],
        ]);
    }

    private function validation(array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:300'],
            'photo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1048'],
        ])->validate();
    }
}
