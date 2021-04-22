<?php

namespace Modules\Types\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Types\Entities\Type;

class TypesDatabaseSeeder extends Seeder
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

        $count = Type::where('parent_id', '!=', 0)->count();
        if($count == 0){
            Type::create([
                'name' => 'BM',
                'name_ar' => 'بي ام',
                'parent_id' => 1,
            ]);
        }
    }
}
