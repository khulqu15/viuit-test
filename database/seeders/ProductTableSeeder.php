<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=10; $i++)
        {
            $product = new Product();
            $product->name = "Product $i";
            $product->price = $i * 1000;
            $product->photo = 'photo_product.png';
            $product->description = 'lorem ipsum';
            $product->user_id = 1;
            $product->save();
        }
    }
}
