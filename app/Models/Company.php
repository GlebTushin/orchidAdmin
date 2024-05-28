<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use HasFactory;
    use AsSource;
    protected $primaryKey= 'company_id';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'company_name',
        'lat',
        'lng',
    ];
}
