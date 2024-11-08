<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesantren extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'akreditasi', 'total_students', 'other_details', 'long', 'latt', 'biaya_bulanan'];

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function extracurriculars()
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function valuations()
    {
        return $this->hasMany(Valuation::class);
    }

    public function latestVikorResult()
    {
        return $this->hasOne(VikorResult::class);
    }

    public function vikorResultHistories()
    {
        return $this->hasMany(VikorResultHistory::class);
    }
}
