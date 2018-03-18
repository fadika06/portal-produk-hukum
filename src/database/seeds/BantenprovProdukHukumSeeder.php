<?php

use Illuminate\Database\Seeder;

class BantenprovProdukHukumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BantenprovProdukHukumSeederProdukHukum::class);
    }
}
