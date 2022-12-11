<?php

namespace App\Http\Controllers;

use App\Models\DeliverySetting;
use App\Services\DeliveryDate;
use Illuminate\Http\Request;

class OrderFromController extends Controller
{
    public function DeliveryForm(DeliveryDate $delivery_date)
    {
        //初期設定値
        $set_value_id = 1;

        //都道府県追加日初期値
        $prefecture_add_date = 0;

        $delivery_dates = $delivery_date->deliveryDates($set_value_id, $prefecture_add_date);

        return view('order_form', compact('delivery_dates', 'set_value_id'));
    }

    public function setValueChange(Request $request, DeliveryDate $delivery_date)
    {
        $prefecture_add_date = 0;
        
        $set_value_id = (int)$request->set_value_id;
        $delivery_dates = $delivery_date->deliveryDates($set_value_id, $prefecture_add_date);

        return view('order_form', compact('delivery_dates', 'set_value_id'));
    }


    public function ajax(Request $request, DeliveryDate $delivery_date)
    {
        $set_value_id = (int)$request->value;
        $prefecture_id = (int)$request->pre;

        $delivery_dates = $delivery_date->leadTime($set_value_id, $prefecture_id);

        return $delivery_dates;
    }
}
