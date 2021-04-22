<?php

namespace Modules\Cities\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Cities\Entities\City;

class CitiesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $count = City::count();
        if($count == 0){
            City::create([
                'name' => 'Cairo',
                'name_ar' => 'القاهره',
                'country_id' => 1,
            ]);
        }

    }
}
