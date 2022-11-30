<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

	    protected $fillable = [
        'name', 'lname', 'class','birthday', 'personalCode', 'schools_id'
    ];
    public function countries()
    {
        return $this->belongsTo(School::class);
    }
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
