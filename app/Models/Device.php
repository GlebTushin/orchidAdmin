<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
class Device extends Model
{
    use HasFactory ,AsSource;
    protected $primaryKey= 'device_id';
    protected $fillable = [
        'name',
        'external_id',
        'phone_number',
        'status',
        'comment',
        'last_ping_at',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'vehicle_id');
    }
}
