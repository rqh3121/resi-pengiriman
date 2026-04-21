<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        $cities = [
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta', 'postal_code' => '10110'],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'postal_code' => '60111'],
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'postal_code' => '40111'],
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'postal_code' => '20111'],
            ['name' => 'Semarang', 'province' => 'Jawa Tengah', 'postal_code' => '50111'],
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'postal_code' => '90111'],
            ['name' => 'Palembang', 'province' => 'Sumatera Selatan', 'postal_code' => '30111'],
            ['name' => 'Denpasar', 'province' => 'Bali', 'postal_code' => '80111'],
            ['name' => 'Yogyakarta', 'province' => 'DIY', 'postal_code' => '55111'],
            ['name' => 'Malang', 'province' => 'Jawa Timur', 'postal_code' => '65111'],
            ['name' => 'Balikpapan', 'province' => 'Kalimantan Timur', 'postal_code' => '76111'],
            ['name' => 'Pontianak', 'province' => 'Kalimantan Barat', 'postal_code' => '78111'],
            ['name' => 'Manado', 'province' => 'Sulawesi Utara', 'postal_code' => '95111'],
            ['name' => 'Padang', 'province' => 'Sumatera Barat', 'postal_code' => '25111'],
            ['name' => 'Pekanbaru', 'province' => 'Riau', 'postal_code' => '28111'],
            ['name' => 'Banjarmasin', 'province' => 'Kalimantan Selatan', 'postal_code' => '70111'],
            ['name' => 'Samarinda', 'province' => 'Kalimantan Timur', 'postal_code' => '75111'],
            ['name' => 'Mataram', 'province' => 'NTB', 'postal_code' => '83111'],
            ['name' => 'Kupang', 'province' => 'NTT', 'postal_code' => '85111'],
            ['name' => 'Jayapura', 'province' => 'Papua', 'postal_code' => '99111'],
            ['name' => 'Tangerang', 'province' => 'Banten', 'postal_code' => '15111'],
            ['name' => 'Bekasi', 'province' => 'Jawa Barat', 'postal_code' => '17111'],
            ['name' => 'Depok', 'province' => 'Jawa Barat', 'postal_code' => '16411'],
            ['name' => 'Bogor', 'province' => 'Jawa Barat', 'postal_code' => '16111'],
            ['name' => 'Cirebon', 'province' => 'Jawa Barat', 'postal_code' => '45111'],
            ['name' => 'Solo', 'province' => 'Jawa Tengah', 'postal_code' => '57111'],
            ['name' => 'Jember', 'province' => 'Jawa Timur', 'postal_code' => '68111'],
            ['name' => 'Palu', 'province' => 'Sulawesi Tengah', 'postal_code' => '94111'],
            ['name' => 'Kendari', 'province' => 'Sulawesi Tenggara', 'postal_code' => '93111'],
            ['name' => 'Gorontalo', 'province' => 'Gorontalo', 'postal_code' => '96111'],
            // Tambahkan sesuai kebutuhan
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}