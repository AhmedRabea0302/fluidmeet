<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pharmacy;


class HomeController extends Controller
{
    public function index() {
        $pharms = Pharmacy::orderBy('created_at', 'DES')->get();
        return view('site.pages.home', ['pharms' => $pharms]);
    }
}
