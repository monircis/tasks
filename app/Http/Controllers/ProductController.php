<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Traits\HasImageUpload;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    use HasImageUpload;
    // Show list
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by SKU
        if ($request->filled('sku')) {
            $query->where('sku', 'like', '%' . $request->sku . '%');
        }

        // Paginate 10 per page
        $products = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Home', [
            'products' => $products,
            'filters' => $request->only(['name', 'sku']),
            'flash' => [
                'success' => session('success')
            ],
        ]);
    }

    // Show create form
    public function create()
    {
        return Inertia::render('Create');
    }

    // Store product
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['image'] = $this->uploadImage($request->file('image'));
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product Created successfully.');

    }

    // Show edit form
    public function edit(Product $product)
    {
        return Inertia::render('Edit', [
            'product' => $product
        ]);
    }

    // Update product
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
{
    $data = $request->validated();

    // Handle image upload
    if ($request->hasFile('image')) {
        $this->deleteImage($product->image);
        $data['image'] = $this->uploadImage($request->file('image'));
    }

    // Update the product
    $product->update($data);

    // Return JSON success response
    return response()->json([
        'success' => true,
        'message' => 'Product updated successfully',
     ]);
}

    //  return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
