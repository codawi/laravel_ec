<?php

namespace App\Http\Controllers;

use App\Models\DeliverySetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class OrderFromController extends Controller
{
    public function DeliveryForm()
    {
        //設定値
        $set_value_id = 1;

        //追加日数
        $add_date = 0;

        $delivery_setting = new DeliverySetting();
        $delivery_dates = $delivery_setting->deliveryDate($add_date, $set_value_id);

        $prefecture_option = DeliverySetting::find($set_value_id, ['prefecture']);

        return view('order_form', compact('delivery_dates', 'option'));
    }

    public function option(Request $request)
    {
        $option = $request->option;
        $delivery_setting = new DeliverySetting();
        $delivery_dates = $delivery_setting->deliveryDate(0, $option);

        return view('order_form', compact('delivery_dates', 'option'));
    }


    public function ajax(Request $request)
    {
        $option = $request->opt;
        $prefecture = intval($request->pre);

        $delivery_setting = new DeliverySetting();

        $delivery_dates = $delivery_setting->leadTime($option, $prefecture);

        return $delivery_dates;
    }
}
