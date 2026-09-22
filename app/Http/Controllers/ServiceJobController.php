<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Mechanic;
use App\Models\ServiceJob;
use Illuminate\Http\Request;

class ServiceJobController extends Controller
{
    // GET /api/service-jobs — apni cars ki saari jobs
    public function index(Request $request)
    {
        $status = $request->query('status');

        $jobs = ServiceJob::whereHas('car', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->with(['car', 'mechanic'])
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->get();

        return response()->json($jobs);
    }

    // POST /api/service-jobs — nayi job create karo
    public function store(Request $request)
    {
        $request->validate([
            'car_id'         => 'required|exists:cars,id',
            'description'    => 'required|string',
            'estimated_cost' => 'nullable|numeric'
        ]);

        // Check karo ke yeh car is user ki hai
        $car = $request->user()->cars()->find($request->car_id);

        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }

        $job = ServiceJob::create([
            'car_id'         => $request->car_id,
            'description'    => $request->description,
            'estimated_cost' => $request->estimated_cost,
            'status'         => 'pending'
        ]);

        return response()->json($job, 201);
    }

    // GET /api/service-jobs/1
    public function show(Request $request, $id)
    {
        $job = ServiceJob::whereHas('car', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->with(['car', 'mechanic'])->find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        return response()->json($job);
    }

    // PATCH /api/service-jobs/1/status — sirf status update karo
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $job = ServiceJob::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->status = $request->status;

        // Agar completed hua toh timestamp save karo
        if ($request->status === 'completed') {
            $job->completed_at = now();
        }

        $job->save();

        return response()->json($job);
    }

    // PATCH /api/service-jobs/1/assign — mechanic assign karo
    public function assignMechanic(Request $request, $id)
    {
        $request->validate([
            'mechanic_id' => 'required|exists:mechanics,id'
        ]);

        $job = ServiceJob::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $mechanic = Mechanic::find($request->mechanic_id);

        if (!$mechanic->is_available) {
            return response()->json([
                'message' => 'Mechanic is not available'
            ], 422);
        }

        // Mechanic assign karo aur unavailable mark karo
        $job->mechanic_id = $request->mechanic_id;
        $job->status = 'in_progress';
        $job->save();

        $mechanic->is_available = false;
        $mechanic->save();

        return response()->json($job->load('mechanic'));
    }
}