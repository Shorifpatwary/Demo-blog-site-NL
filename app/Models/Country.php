<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name'
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function state()
    {
        return $this->hasMany(State::class);
    }
}
