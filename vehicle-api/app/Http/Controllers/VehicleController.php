<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{
    /**
     * Get all vehicles with optional filters.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Vehicle::query();

            // Apply filters
            if ($request->has('availability')) {
                $query->available();
            }

            if ($request->has('type')) {
                $query->ofType($request->input('type'));
            }

            if ($request->has('financial_status')) {
                $query->withFinancialStatus($request->input('financial_status'));
            }

            // Get all vehicles with pagination
            $vehicles = $query->paginate(10);

            return response()->json([
                'vehicles' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new vehicle.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate incoming request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'type' => 'required|in:Car,Bike,Van,Truck,SUV',
                'price_per_day' => 'required|numeric|min:0',
                'availability' => 'required|boolean',
                'description' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'nullable|url',
                'owner_id' => 'nullable|exists:users,id',
                'financial_status' => 'required|in:Active,Suspended,Bankrupt',
            ]);

            // Create a new vehicle record
            $vehicle = Vehicle::create($validated);

            return response()->json([
                'message' => 'Vehicle created successfully',
                'vehicle' => $vehicle
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
