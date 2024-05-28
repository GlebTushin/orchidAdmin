<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Vehicle extends Model
{
    use HasFactory,AsSource;
    protected $primaryKey= 'vehicle_id';
    protected $fillable = [
        'name',
        'speed' ,
        'number', 
        'lat'  ,
        'lng', 

    ];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id', 'company_id');
    }
}
