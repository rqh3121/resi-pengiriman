<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SenderAddress;

class SenderAddressSeeder extends Seeder
{
    public function run()
    {
        SenderAddress::create([
            'name' => 'PT PELITA INDONESIA DJAYA',
            'address' => 'Jl. Angkasa No.18, RT.2/RW.9, Gn. Sahari Sel., Kec. Kemayoran, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10610',
            'contact' => '+62 851-8307-3715'
        ]);
        // Tambahkan alamat lain jika diperlukan di sini
    }
}