<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Address;
use App\Car;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Return a list of all addresses, along with the
     * owner's name for the address, and the number of
     * cars per address.
     *
     * @return array
     */
    public function index(): array
    {
        // Perform the query to return the results, using 
        // only the Eloquent ORM (no query builder used)
        return Address::with('owner')
            ->withCount('cars')
            ->orderBy('addresses.id')
            ->get()
            ->toArray();
    }

    /**
     * Return a single address.
     *
     * @param Address $address
     * @return Address
     */
    public function show(Address $address): Address
    {
        return $address;
    }

    /**
     * Return a list of all addresses for an owner.
     * 
     * @return array
     */
    public function showAddressesForOwner(Owner $owner): array
    {
        // Using the query builder for this... - ALA
        return Address::selectRaw('addresses.*')
            ->where('owner_id', '=', $owner->id)
            ->join('owners', 'owners.id', '=', 'addresses.owner_id')
            ->orderBy('id')
            ->get()
            ->toArray();
    }

    /**
     * Return the address for a car.
     * 
     * @return object
     */
    public function showAddressForCar(Car $car): object
    {
        // Using the query builder for this... - ALA
        return Address::selectRaw('addresses.*')
            ->join('cars', 'cars.address_id', '=', 'addresses.id')
            ->join('owners', 'owners.id', '=', 'addresses.owner_id')
            ->where('cars.id', '=', $car->id)
            ->first();
    }

    /**
     * Store an address.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }

    /**
     * Update an address.
     *
     * @param Request $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        $address->update($request->all());

        return response()->json($address, 200);
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Address $address): JsonResponse
    {
        $address->delete();

        return response()->json(null, 204);
    }

    /**
     * Return a JSON encoded string containing address average
     * 
     * @return String
     */
    public function getAddressAverages(): String
    {
        // Original submitted method... - ALA
        /*
        $adds = DB::select("SELECT COUNT(*) FROM addresses")[0];
        $cars = DB::select("SELECT COUNT(*) FROM cars")[0];

        $cars = array(
            "average" => number_format(($cars->count / $adds->count))
        );
        */

        // New method #1
        /*
        $cars = (object) DB::select("SELECT ROUND(
                                COUNT(cars.id)::numeric / COUNT(DISTINCT addresses.id)::numeric) 
                                AS average 
                                FROM cars 
                                    JOIN addresses ON addresses.id = cars.address_id")[0];
        */

        // New method #2
        //
        $result = DB::select("SELECT ROUND(AVG(count)) AS avg_cars
                                FROM (SELECT COUNT(*)
                                    FROM cars 
                                    JOIN addresses ON addresses.id = cars.address_id 
                                    GROUP BY addresses.id ORDER BY addresses.id) AS foo")[0];

        $cars = array("average" => $result->avg_cars);

        return json_encode((object) array("cars" => $cars));
    }
}
