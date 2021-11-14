<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $fillable = ['make', 'model', 'year', 'owner_id']; 

    /**
     * Get the owner associated with an car.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the owner associated with an car.
     *
     * @return HasOne
     */
    public function owners(): HasOne
    {
        return $this->hasOne(Owner::class);
    }

    /**
     * Get the address associated with a car.
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the address associated with a car.
     *
     * @return HasOne
     */
    public function addresses(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function getTypes(): array
    {
        return json_decode(file_get_contents(storage_path() . '/json/car-data.json'), true);
    }
}
