<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return ApiResponseMessageWithErrors("one or more fields validation required", $validator->errors(), 422);
        }

        $product = Product::create($request->all());
        return ApiResponseData(new ProductResource($product));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return ApiResponseData(new ProductResource($product));
        } catch (\Exception $e) {
            return ApiResponseMessageWithErrors('Product not found', '', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return ApiResponseMessageWithErrors("one or more fields validation required", $validator->errors(), 422);
            }

            $product->update($request->all());

            return ApiResponseData(new ProductResource($product));
        } catch (\Exception $e) {
            return ApiResponseMessageWithErrors('Product not found', '', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return ApiResponseData(null, 204);
        } catch (\Exception $e) {
            return ApiResponseMessageWithErrors('Product not found', '', 404);
        }
    }
}
