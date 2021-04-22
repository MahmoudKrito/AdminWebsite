<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Categories\Entities\Category;

class CategoriesDatabaseSeeder extends Seeder
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
        $count = Category::where('parent_id',0)->count();
        if($count == 0){
            Category::create([
                'name' => 'cars',
                'name_ar' => 'سيارات',
                'gender_id' => 1,
                'layout_id' => 1,
            ]);
        }

    }
}
