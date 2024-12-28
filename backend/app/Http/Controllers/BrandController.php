<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:brands,name',
        ]);

        $brand = Brand::create($request->all());
        return response()->json($brand, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        $brand->update($request->all());
        return  response()->json($brand);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $brand = Brand::find($id);
            $brand->status = $request->input('status');
            $brand->save();

            return response()->json([
                'message' => 'Estado de la Marca actualizado correctamente.',
                'status' => $brand->status,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Marca no encontrada.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado de la Marca.',
            ], 500);
        }
    }
}
