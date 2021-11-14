<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    // Ref: https://stackoverflow.com/questions/53793841/add-title-to-fillable-property-to-allow-mass-assignment-on-app-post
    protected $fillable = ['address', 'city', 'country', 'postal_code', 'owner_id'];

    /**
     * Get the owner associated with an address.
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Get the owner associated with an address.
     *
     * @return HasOne
     */
    public function owners(): HasOne
    {
        return $this->hasOne(Owner::class);
    }

    /**
     * Get cars associated with an address.
     *
     * @return HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
