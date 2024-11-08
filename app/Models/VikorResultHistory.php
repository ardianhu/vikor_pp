<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VikorResultHistory extends Model
{
    use HasFactory;
    protected $fillable = ['pesantren_id', 'vikor_score', 'rank', 'calculated_at'];

    public function school()
    {
        return $this->belongsTo(Pesantren::class);
    }
}
