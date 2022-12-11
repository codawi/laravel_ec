<?php

namespace App\Services;

use App\Models\DeliverySetting;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DeliveryDate
{
  public function deliveryDates($set_value_id, $prefecture_add_date)
  {
    //初期化
    $delivery_dates = [];

    $set_value = DeliverySetting::find($set_value_id);

    //選択肢数
    $options = $set_value->option;
    //締め切り時間設定
    $is_deadline = $set_value->deadline;
    //土日配送設定
    $is_weekend_delivery = $set_value->weekend_delivery;

    $now_date = Carbon::now();

    //最短配送日
    $delivery_date = $now_date->addWeekdays($set_value->shortest_delivery + $prefecture_add_date);

    //当日締め切り時間(15:00)判定
    if ($is_deadline === 1 && $now_date->hour >= 15) {
      //土日配送不可
      if ($set_value->weekend_delivery === 1) {
        $delivery_date->addWeekday();
      } else {
        //土日配送可
        $delivery_date->addDay();
      }
    }

    //選択肢数分配送日を取得
    for ($i = 0; $i < $options; $i++) {
      //土日配送不可設定の場合
      if ($is_weekend_delivery === 1 && $delivery_date->isWeekend()) {
        $delivery_date->addWeekday();
      }
      $delivery_dates[] = $delivery_date->isoformat('Y月M月D日(ddd)');
      $delivery_date->addDay();
    };

    return $delivery_dates;
  }

  public function leadTime($set_value_id, $prefecture_id)
  {
    switch ($set_value_id) {
      case 1:
        $prefecture = ['北海道' => 2, '沖縄' => 3, 'その他' => 0];
        break;
      case 2:
        $prefecture = ['北海道' => 3, '沖縄' => 3, 'その他' => 0];
        break;
    }

    //北海道か沖縄の場合最短日+n日
    if ($prefecture_id === 1) {
      $delivery_dates = $this->deliveryDates($set_value_id, $prefecture['北海道']);
    } elseif ($prefecture_id === 47) {
      $delivery_dates = $this->deliveryDates($set_value_id, $prefecture['沖縄']);
    } else {
      $delivery_dates = $this->deliveryDates($set_value_id, $prefecture['その他']);
    }
    return $delivery_dates;
  }
}
