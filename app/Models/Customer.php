<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'companyname',
        'phonenumber',
        'description',
        'website',
        'address',
        'status'
    ];

    public function contact() : HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function orders() : HasMany
    {
        return $this->hasMany(Orders::class);
    }

}
