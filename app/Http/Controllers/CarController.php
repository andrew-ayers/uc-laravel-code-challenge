<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Address;
use App\Car;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Return a list of all cars, along with the
     * address and owner's name for each car.
     *
     * @return array
     */
    public function index(): array
    {
        // Perform the query to return the results, using 
        // only the Eloquent ORM (no query builder used)
        return Car::with('owner')
            ->with('address')
            ->orderBy('cars.id')
            ->get()
            ->toArray();
    }

    /**
     * Return a single car.
     *
     * @param Car $car
     * @return Car
     */
    public function show(Car $car): Car
    {
        return $car;
    }

    /**
     * Return a list of all cars for an owner.
     * 
     * @return array
     */
    public function showCarsForOwner(Owner $owner): array
    {
        // Using the query builder for this... - ALA
        return Car::selectRaw('cars.*')
            ->where('owner_id', '=', $owner->id)
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    /**
     * Return a list of all cars for an address.
     * 
     * @return array
     */
    public function showCarsForAddress(Address $address): array
    {
        // Using the query builder for this... - ALA
        return Car::selectRaw('cars.*')
            ->where('address_id', '=', $address->id)
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    /**
     * Store an car.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $car = Car::create($request->all());

        return response()->json($car, 201);
    }

    /**
     * Update an car.
     *
     * @param Request $request
     * @param Car $car
     * @return JsonResponse
     */
    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update($request->all());

        return response()->json($car, 200);
    }

    /**
     * Delete an car.
     *
     * @param Car $car
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Car $car): JsonResponse
    {
        $car->delete();

        return response()->json(null, 204);
    }
}
