<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_settings')->insert([
            //最短配送日翌日、選択肢5、15以降でも翌日配送、土日配送可、北海道最短+2日沖縄最短+3日の設定値
            [
                'shortest_delivery' => '1',
                'option' => '5',
                'deadline' => '0',
                'weekend_delivery' => '0',
                'prefecture' => '1'
            ],
            //最短配送日明後日、選択肢10、15時以降最短+1日、土日配送不可、北海道+3日沖縄+3日の設定値
            [
                'shortest_delivery' => '2',
                'option' => '10',
                'deadline' => '1',
                'weekend_delivery' => '1',
                'prefecture' => '2'
            ]
        ]);
    }
}
