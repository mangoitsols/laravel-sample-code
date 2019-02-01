<?php

namespace App\Http\Controllers;

use App\PropertyType;
use App\Country;
use App\State;
use App\City;
use App\Property;
use App\Tenant;
use App\Http\Controllers\QuickBooksController;

class PageController extends Controller
{

    /**
     * Orders controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Header links
    public function account() { return view('account'); }
    public function reports() { return view('reports'); }
    public function changePassword() { return view('change_password'); }
    public function adminSettings() { return view('settings'); }

    // Sidebar links
    public function dashboard() { return view('dashboard'); }
    public function vendors() { return view('vendors'); }
    public function financials() { return view('financials'); }
    public function banking() { return view('banking'); }
    public function workOrders() { return view('work_orders'); }
    public function bills() { return view('bills'); }

}
