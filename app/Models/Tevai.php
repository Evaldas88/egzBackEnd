<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tevai extends Model
{
    use HasFactory;

	    protected $fillable = [
        'name', 'lname', 'class','birthday', 'personalCode', 'darzelis_id'
    ];
    public function countries()
    {
        return $this->belongsTo(Darzelis::class);
    }
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}
