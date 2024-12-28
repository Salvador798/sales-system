<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Client::all();
        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|max:15|unique:clients,ci',
            'name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $client = Client::create($request->all());
        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);
        $client->update($request->all());
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $client = Client::find($id);
            $client->status = $request->input('status');
            $client->save();

            return response()->json([
                'message' => 'Estado de la cliente actualizado correctamente.',
                'status' => $client->status,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cliente no encontrada.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el estado de la cliente.',
            ], 500);
        }
    }
}
