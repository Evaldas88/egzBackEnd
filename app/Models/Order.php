<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'approved'
    ];

    public function tevai()
    {
        return $this->belongsTo(Tevai::class, 'tevais_id');
    }
}
