<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Show the pricing page.
     */
    public function index()
    {
        $plans = Plan::active()->get();
        return view('pricing', compact('plans'));
    }
}
