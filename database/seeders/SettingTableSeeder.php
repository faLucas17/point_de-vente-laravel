<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Toko Ku',
            'alamat' => 'Jl. Kibandang Samaran Ds. Slangit',
            'telepon' => '778228460',
            'tipe_nota' => 1, // kecil
            'diskon' => 5,
            'path_logo' => 'logo-20240118140040.png',
            'path_kartu_member' => 'logo-2024-01-19213756.png',
        ]);
    }
}
