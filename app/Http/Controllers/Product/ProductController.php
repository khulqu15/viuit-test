<?php

namespace App\Http\Controllers\Product;

use App\Actions\Product\CreateProduct;
use App\Actions\Product\EditProduct;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = Product::query()
        ->when($request->get('name'), function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        })
        ->orderBy('id', $request->get('sort', 'desc'))
        ->paginate(5);
        foreach ($products as $key => $value)
            $products[$key]['hash'] = $value->hash;

        return Inertia::render('Product/Index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateProduct $action
     * @return RedirectResponse
     */
    public function store(Request $request, CreateProduct $action): RedirectResponse
    {
        $upload = $this->upload_photo($request, 'product', public_path().'/img/product/', null);
        $action->store($request->all(), $upload);
        return redirect()->route('products')->with('success', 'Product Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product): Response
    {
        $product->hash = $product->hash;
        return Inertia::render('Product/Edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param EditProduct $action
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product, EditProduct $action): RedirectResponse
    {
        $upload = $this->upload_photo($request, 'product', public_path().'/img/product/', $product);
        $action->update($request->all(), $upload, $product);
        return redirect()->route('products')->with('success', 'Product has updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        if(File::isFile(public_path().'/img/product/'.$product->photo) && $product->photo)
            unlink(public_path().'/img/product/'.$product->photo);

        $product->delete();
        return redirect()->route('products')->with('success', 'Product deleted');
    }
}
