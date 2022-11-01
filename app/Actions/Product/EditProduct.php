<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditProduct
{
    /**
     * @param array $input
     * @param $filename
     * @param mixed $product
     * @return bool|int
     * @throws ValidationException
     */
    public function update(array $input, $filename, mixed $product): bool|int
    {
        $this->validation($input);
        $updates = [
            'user_id' => Auth::id(),
            'name' => $input['name'],
            'price' => $input['price'],
            'description' => $input['description'],
        ];
        if($filename)
            $updates['photo'] = $filename;

        return Product::query()->find($product->id)->update($updates);
    }

    /**
     * @param array $input
     * @return void
     * @throws ValidationException
     */
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
