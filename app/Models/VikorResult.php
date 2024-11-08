<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VikorResult extends Model
{
    use HasFactory;
    protected $fillable = ['pesantren_id', 'vikor_score', 'rank'];

    public function pesantren()
    {
        return $this->belongsTo(Pesantren::class);
    }
}
