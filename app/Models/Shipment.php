<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_name',
        'sender_contact',
        'sender_address',
        'receiver_name',
        'receiver_contact',
        'receiver_address',
        'receiver_city',
        'package_count',
        'resi_number',
        'expedition',
        'resi_photo',
        'item_description',
        'weight',
        'shipping_cost',
        'project_id',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}