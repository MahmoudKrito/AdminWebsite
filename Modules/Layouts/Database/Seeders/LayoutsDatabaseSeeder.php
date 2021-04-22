<?php

namespace Modules\Layouts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Layouts\Entities\Layout;

class LayoutsDatabaseSeeder extends Seeder
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
        $count = Layout::count();
        if ($count == 0) {
            Layout::create([
                'name' => 'layout 1'
            ]);
        }
    }
}
