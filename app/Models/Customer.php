<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fullName() : Attribute
    {
        return new Attribute(
            /* get: */function() {
                return trim(sprintf("%s %s", $this->first_name, $this->last_name));
            }
        );
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
