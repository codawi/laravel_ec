<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class DeliverySetting extends Model
{
    use HasFactory;

    public function deliveryDate($add_date, $set_value_id)
    {
        $set_value = DeliverySetting::find($set_value_id);
        $now_date = Carbon::now();
        $end_date = Carbon::now();

        //初期化
        $delivery_dates = [];

        //選択肢数
        $options = $set_value->options;

        //最短&最遅配送日
        $start_date = $now_date->addWeekdays($set_value->shortest_delivery + $add_date);
        $end_date = $end_date->addWeekdays($set_value->shortest_delivery + $add_date);

        //当日締め切り時間判定
        $limit = Carbon::createFromTimeString('15:00:00');
        if ($start_date->gt($limit)) {
            //土日配送可
            if ($set_value->weekend_delivery === 0) {
                $start_date->addDay();
                $end_date_str = $end_date->addDays($options)->format('Y-m-d');
            } else {
                //土日配送不可
                $start_date->addWeekday();
                $end_date_str = $end_date->addWeekdays($options)->format('Y-m-d');
            }
        }

        //配送日一覧取得
        $start_date_str = $start_date->format('Y-m-d');
        if ($set_value->weekend_delivery === 0) {
            //土日含めて一覧取得
            $period = CarbonPeriod::create($start_date_str, $end_date_str)->toArray();
        } else {
            //土日除いて一覧取得
            $period = CarbonPeriod::create($start_date_str, $end_date_str)->filter('isWeekday')->toArray();
        }

        foreach ($period as $delivery_date) {
            $delivery_dates[] = $delivery_date->isoformat('Y月M月D日(ddd)');
        }

        return $delivery_dates;
    }

    public function leadTime($option, $prefecture_option)
    {
        $delivery_setting = new DeliverySetting();

        switch ($option) {
            case 1:
                $prefecture = ['北海道' => 2, '沖縄' => 3, 'その他' => 0];
                break;
            case 2:
                $prefecture = ['北海道' => 3, '沖縄' => 3, 'その他' => 0];
                break;
        }

        //北海道か沖縄の場合最短日+n日
        if ($prefecture_option === 1) {
            $delivery_dates = $delivery_setting->deliveryDate($prefecture['北海道'], $option);
        } elseif ($prefecture_option === 47) {
            $delivery_dates = $delivery_setting->deliveryDate($prefecture['沖縄'], $option);
        } else {
            $delivery_dates = $delivery_setting->deliveryDate($prefecture['その他'], $option);
        }
        return $delivery_dates;
    }
}
