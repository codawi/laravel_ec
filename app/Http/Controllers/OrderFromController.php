<?php

namespace App\Http\Controllers;

use App\Models\DeliverySetting;
use Illuminate\Http\Request;

class OrderFromController extends Controller
{
    public function index()
    {
        $option = DeliverySetting::find(1);
        return view('order_form', compact('option'));
    }
}
