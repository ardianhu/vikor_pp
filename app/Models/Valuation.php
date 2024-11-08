<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuation extends Model
{
    use HasFactory;
    protected $fillable = ['pesantren_id', 'criteria_id', 'value'];

    public function pesantren()
    {
        return $this->belongsTo(Pesantren::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
