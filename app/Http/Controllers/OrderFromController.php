<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderFromController extends Controller
{
    public function index()
    {
        return view('order_form');
    }
}
