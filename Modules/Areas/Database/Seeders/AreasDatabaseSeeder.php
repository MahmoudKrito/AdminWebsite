<?php

namespace Modules\Areas\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Areas\Entities\Area;

class AreasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $count = Area::count();
        if($count == 0){
            Area::create([
                'name' => 'Nasir City',
                'name_ar' => 'مدينه نصر',
                'city_id' => 1,
            ]);
        }
    }
}
