<?php

namespace Modules\Currencies\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Currencies\Entities\Currency;

class CurrenciesDatabaseSeeder extends Seeder
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
        $count = Currency::count();
        if ($count == 0) {
            Currency::create([
                'name' => 'EGP',
                'name_ar' => 'جنيه',
                'symbol' => 'LE',
            ]);
        }

    }
}
