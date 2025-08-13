<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->has('active')) {
            $query->where('active', filter_var($request->input('active'), FILTER_VALIDATE_BOOL));
        }

        $sort = $request->input('sort', 'name');
        $dir = $request->input('dir', 'asc');
        $query->orderBy($sort, $dir === 'desc' ? 'desc' : 'asc');

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => ['required','string','max:255','unique:products,sku'],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'unit_of_measure' => ['required','string','max:32'],
            'reorder_point' => ['nullable','integer','min:0'],
            'lead_time_days' => ['nullable','integer','min:0'],
            'price' => ['nullable','numeric','min:0'],
            'active' => ['boolean'],
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('materials'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => ['sometimes','string','max:255', Rule::unique('products','sku')->ignore($product->id)],
            'name' => ['sometimes','string','max:255'],
            'description' => ['nullable','string'],
            'unit_of_measure' => ['sometimes','string','max:32'],
            'reorder_point' => ['nullable','integer','min:0'],
            'lead_time_days' => ['nullable','integer','min:0'],
            'price' => ['nullable','numeric','min:0'],
            'active' => ['boolean'],
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
