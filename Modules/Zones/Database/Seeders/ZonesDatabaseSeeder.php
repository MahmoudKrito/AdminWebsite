<?php

namespace Modules\Zones\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Zones\Entities\Zone;

class ZonesDatabaseSeeder extends Seeder
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

        $count = Zone::count();
        if($count == 0){
            Zone::create([
                'name' => 'el sabe3',
                'name_ar' => 'الحي السابع',
                'area_id' => 1,
            ]);
        }
    }
}
