<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filecategory;

class FilecategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Filecategory::create(
        [
            'name' => 'SK',
            'user_id' => '1',
        ]);
        Filecategory::create(
        [
            'name' => 'KTP',
            'user_id' => '1',
        ]);
        Filecategory::create(
        [
            'name' => 'Akta Lahir',
            'user_id' => '2',
        ]);
    }
}
