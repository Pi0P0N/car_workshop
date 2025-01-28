<?php

namespace App\Http\Controllers;

use App\Models\RepairType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cardsInfo = RepairType::all();
        return view('dashboard.home', ['cardsInfo' => $cardsInfo]);
    }
}
