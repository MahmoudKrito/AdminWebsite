<?php

namespace Modules\Countries\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Countries\Entities\Country;

class CountriesDatabaseSeeder extends Seeder
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

        $count = Country::count();
        if($count == 0){
            Country::create([
                'name' => 'Egypt',
                'name_ar' => 'مصر',
                'code' => 'eg',
                'phone_code' => '002',
                'currency_id' => 1,
            ]);
        }
    }
}
