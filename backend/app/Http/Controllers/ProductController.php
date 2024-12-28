<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with('category', 'brand')->get();
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:products,code',
            'description' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'status' => 'required|boolean'
        ]);

        $product = new Product();
        $product->code = $request->code;
        $product->description = $request->description;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category', 'brand')->find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $product = Product::find($id);
            $product->status = $request->input('status');
            $product->save();

            return response()->json([
                'message' => 'Proveedor actualizado correctamente..',
                'status' => $product->status,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Producto no encontrada.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado de la Producto.',
            ], 500);
        }
    }
}
