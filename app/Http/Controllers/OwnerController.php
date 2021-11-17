<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Address;
use App\Car;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Return a list of all owners, along with counts 
     * of addresses and number of cars per owner.
     *
     * @return array
     */
    public function index(): array
    {
        return Owner::withCount('addresses')
            ->withCount('cars')            
            ->orderBy('owners.id')
            ->get()
            ->toArray();
    }

    /**
     * Return a single owner.
     *
     * @param Owner $owner
     * @return Owner
     */
    public function show(Owner $owner): Owner
    {
        return $owner;
    }

    /**
     * Return the owner for an address.
     * 
     * @return object
     */
    public function showOwnerForAddress(Address $address): object
    {
        // Using the query builder for this... - ALA
        return Owner::selectRaw('owners.*')
            ->join('addresses', 'addresses.owner_id', '=', 'owners.id')
            ->where('addresses.id', '=', $address->id)
            ->first();
    }

    /**
     * Return the owner for a car.
     * 
     * @return object
     */
    public function showOwnerForCar(Car $car): object
    {
        // Using the query builder for this... - ALA
        return Owner::selectRaw('owners.*')
            ->join('cars', 'cars.owner_id', '=', 'owners.id')
            ->where('cars.id', '=', $car->id)
            ->first();
    }

    /**
     * Store an owner.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $owner = Owner::create($request->all());

        return response()->json($owner, 201);
    }

    /**
     * Update an owner.
     *
     * @param Request $request
     * @param Owner $owner
     * @return JsonResponse
     */
    public function update(Request $request, Owner $owner): JsonResponse
    {
        $owner->update($request->all());

        return response()->json($owner, 200);
    }

    /**
     * Delete an owner.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Owner $owner): JsonResponse
    {
        $owner->delete();

        return response()->json(null, 204);
    }

    /**
     * Return a JSON encoded string containing owner average(s)
     * 
     * @return String
     */
    public function getOwnerAverages(): String
    {
        // Original submitted method... - ALA
        /*
        $owns = DB::select("SELECT COUNT(*) FROM owners")[0];
        $adds = DB::select("SELECT COUNT(*) FROM addresses")[0];
        $cars = DB::select("SELECT COUNT(*) FROM cars")[0];

        $addresses = array(
            "average" => number_format(($adds->count / $owns->count))
        );

        $cars = array(
            "average" => number_format(($cars->count / $owns->count))
        );
        */

        // New method #1
        /*
        $addresses = DB::select("SELECT ROUND(
                                    COUNT(addresses.id)::numeric / COUNT(DISTINCT owners.id)::numeric) 
                                AS average
                                FROM addresses 
                                    JOIN owners ON owners.id = addresses.owner_id")[0];
        
        $cars = DB::select("SELECT ROUND(
                                COUNT(cars.id)::numeric / COUNT(DISTINCT owners.id)::numeric) 
                            AS average
                            FROM cars 
                                JOIN owners ON owners.id = cars.owner_id")[0];
        */
        
        // New method #2
        /*
        $addresses = (object) DB::select("SELECT ROUND(AVG(count)) AS average
                                FROM (SELECT owners.id, COUNT(*)
                                    FROM addresses 
                                        JOIN owners ON owners.id = addresses.owner_id 
                                    GROUP BY owners.id ORDER BY owners.id) AS foo")[0];
 
        $cars = (object) DB::select("SELECT ROUND(AVG(count)) AS average
                                FROM (SELECT owners.id, COUNT(*)
                                    FROM cars 
                                        JOIN owners ON owners.id = cars.owner_id 
                                    GROUP BY owners.id ORDER BY owners.id) AS bar")[0];
        */
        
        // New method #3
        //        
        $results = DB::select("SELECT ROUND(AVG(foo.a_cnt)) AS avg_adds, 
                                    ROUND(AVG(bar.c_cnt)) AS avg_cars
                                FROM (SELECT owners.id AS owner_id, COUNT(*) AS a_cnt
                                    FROM addresses 
                                    JOIN owners ON owners.id = addresses.owner_id 
                                    GROUP BY owners.id ORDER BY owners.id) AS foo
                                JOIN (SELECT owners.id AS owner_id, COUNT(*) AS c_cnt
                                    FROM cars 
                                    JOIN owners ON owners.id = cars.owner_id 
                                    GROUP BY owners.id ORDER BY owners.id) AS bar
                                ON foo.owner_id = bar.owner_id")[0];
        
        $addresses = array("average" => $results->avg_adds);
        $cars = array("average" => $results->avg_cars);

        return json_encode((object) array("addresses" => $addresses, "cars" => $cars));
    }
}
