<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = 
        [
            //最短配送日翌日、選択肢5、15以降でもずらさない、土日配送可、北海道最短+2日沖縄最短+3日
            [
                'shortest_delivery_dates' => '1',
                'options' => '5',
                'change_delivery_dates' => '0',
                'delivery_not_possible' => '0',
                'prefecture' => '0'
            ]
        ]
    }
}
