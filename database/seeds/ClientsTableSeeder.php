<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Client::create([
            'name'=>'Ahmed Tawfik',
            'phone'=>'01016101610',
            'address'=>'Nasr City, Cairo'
        ]);
    }
}
