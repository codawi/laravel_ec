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
        $option = 1;
        $day = 0;

        $delivery_setting = new DeliverySetting();
        $delivery_dates = $delivery_setting->deliveryDate($day, $option);

        $prefecture_option = DeliverySetting::find($option, ['prefecture']);

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
