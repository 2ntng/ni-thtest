<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nama_barang' => 'Laptop HP DK0076AU',
                'foto_barang' => 'https://example.com/laptop_hp_dk0076au.jpg',
                'harga_beli' => 7500000,
                'harga_jual' => 8000000,
                'stok' => 50,
            ],
            [
                'id' => 2,
                'nama_barang' => 'iPhone 12 Pro',
                'foto_barang' => 'https://example.com/iphone_12_pro.jpg',
                'harga_beli' => 12000000,
                'harga_jual' => 13500000,
                'stok' => 30,
            ],
            [
                'id' => 3,
                'nama_barang' => 'Samsung Galaxy S21',
                'foto_barang' => 'https://example.com/samsung_galaxy_s21.jpg',
                'harga_beli' => 11000000,
                'harga_jual' => 12500000,
                'stok' => 45,
            ],
            [
                'id' => 4,
                'nama_barang' => 'Smart TV LG 55-inch',
                'foto_barang' => 'https://example.com/smart_tv_lg.jpg',
                'harga_beli' => 5000000,
                'harga_jual' => 5500000,
                'stok' => 20,
            ],
            [
                'id' => 5,
                'nama_barang' => 'Kamera Canon EOS 80D',
                'foto_barang' => 'https://example.com/canon_eos_80d.jpg',
                'harga_beli' => 8000000,
                'harga_jual' => 8500000,
                'stok' => 15,
            ],
        ];

        Barang::insert($data);
    }
}
