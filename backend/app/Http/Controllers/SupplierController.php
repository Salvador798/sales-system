<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rif' => 'required|string|max:50|unique:suppliers,rif',
            'name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $supplier = Supplier::create($request->all());
        return response()->json($supplier, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update($request->all());
        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $supplier = Supplier::find($id);
            $supplier->delete();
            return response()->json([], 204);

            return response()->json([
                'message' => 'Estado de la Proveedor actualizado correctamente.',
                'status' => $supplier->status,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Provvedor no encontrada.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado de la proveedor.',
            ], 500);
        }
    }
}
