<?php

namespace Modules\Genders\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Genders\Entities\Gender;

class GendersDatabaseSeeder extends Seeder
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
        $count = Gender::count();
        if ($count == 0) {
            Gender::create([
                'name' => 'female',
                'name_ar' => 'انثي',
            ]);
            Gender::create([
                'name' => 'male',
                'name_ar' => 'ذكر',
            ]);
        }
    }
}
