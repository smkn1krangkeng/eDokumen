<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Myfile;

class MyfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Myfile::create([
            'name' => 'File SK',
            'path' => '',
            'is_public' => true,
            'filecategory_id' => '1',
            'user_id' => '1',
        ]);
        Myfile::create([
            'name' => 'File KTP',
            'path' => '',
            'is_public' => false,
            'filecategory_id' => '2',
            'user_id' => '1',
        ]);
        Myfile::create([
            'name' => 'File Akta Lahir',
            'path' => '',
            'is_public' => false,
            'filecategory_id' => '3',
            'user_id' => '2',
        ]);
        Myfile::create([
            'name' => 'File SPPD',
            'path' => '',
            'is_public' => true,
            'filecategory_id' => '4',
            'user_id' => '2',
        ]);
    }
}
