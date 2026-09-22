<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // GET /api/cars — sirf apni cars dekho
    public function index(Request $request)
    {
        $cars = $request->user()->cars;
        return response()->json($cars);
    }

    // POST /api/cars — apni car add karo
    public function store(Request $request)
    {
        $request->validate([
            'make'         => 'required|string',
            'model'        => 'required|string',
            'year'         => 'required|integer',
            'plate_number' => 'required|string|unique:cars',
            'vin'          => 'nullable|string|unique:cars'
        ]);

        $car = $request->user()->cars()->create($request->all());
        return response()->json($car, 201);
    }

    // GET /api/cars/1 — specific car dekho
    public function show(Request $request, $id)
    {
        $car = $request->user()->cars()->find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        return response()->json($car);
    }

    // PUT /api/cars/1 — car update karo
    public function update(Request $request, $id)
    {
        $car = $request->user()->cars()->find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->update($request->all());
        return response()->json($car);
    }

    // DELETE /api/cars/1 — car delete karo
    public function destroy(Request $request, $id)
    {
        $car = $request->user()->cars()->find($id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $car->delete();
        return response()->json(['message' => 'Car deleted successfully']);
    }
}