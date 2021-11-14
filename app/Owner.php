<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    // Ref: https://stackoverflow.com/questions/53793841/add-title-to-fillable-property-to-allow-mass-assignment-on-app-post
    protected $fillable = ['first_name', 'last_name'];

    /**
     * Get addresses associated with an owner.
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get cars associated with an owner.
     *
     * @return HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
