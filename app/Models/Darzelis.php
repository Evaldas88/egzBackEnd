<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Darzelis extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'code'
    ];
    public function parents()
    {
        return $this->hasMany(Tevai::class);
    }
}
