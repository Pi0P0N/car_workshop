<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        return view('dashboard.employee.employeePanel');
    }
    public function getClientsList()
    {
        return view('dashboard.manager.clients');
    }
}