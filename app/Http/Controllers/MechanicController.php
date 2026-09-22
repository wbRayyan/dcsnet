<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    // GET /api/mechanics — saare mechanics
    public function index()
    {
        return response()->json(Mechanic::all());
    }

    // POST /api/mechanics — naya mechanic add karo
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string',
            'specialization' => 'required|string',
            'employee_id'    => 'required|string|unique:mechanics',
            'phone'          => 'nullable|string',
        ]);

        $mechanic = Mechanic::create($request->all());
        return response()->json($mechanic, 201);
    }

    // GET /api/mechanics/1
    public function show($id)
    {
        $mechanic = Mechanic::find($id);

        if (!$mechanic) {
            return response()->json(['message' => 'Mechanic not found'], 404);
        }

        return response()->json($mechanic);
    }

    // PUT /api/mechanics/1
    public function update(Request $request, $id)
    {
        $mechanic = Mechanic::find($id);

        if (!$mechanic) {
            return response()->json(['message' => 'Mechanic not found'], 404);
        }

        $mechanic->update($request->all());
        return response()->json($mechanic);
    }

    // DELETE /api/mechanics/1
    public function destroy($id)
    {
        $mechanic = Mechanic::find($id);

        if (!$mechanic) {
            return response()->json(['message' => 'Mechanic not found'], 404);
        }

        $mechanic->delete();
        return response()->json(['message' => 'Mechanic deleted']);
    }
}