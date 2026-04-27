<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = 
    ['no_proyek',
    'judul_proyek', 
    'spk', 
    'spmk', 
    'bakn'];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    // Helper untuk mengetahui file upload ada atau tidak
    public function getSpkUrlAttribute()
    {
        return $this->spk ? asset('storage/' . $this->spk) : null;
    }

    public function getSpmkUrlAttribute()
    {
        return $this->spmk ? asset('storage/' . $this->spmk) : null;
    }

    public function getBaknUrlAttribute()
    {
        return $this->bakn ? asset('storage/' . $this->bakn) : null;
    }
}