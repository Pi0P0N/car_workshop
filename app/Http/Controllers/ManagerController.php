<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        // Your logic for the employee dashboard
        return view('dashboard.employee.employeePanel');
    }
    public function getClientsList()
    {
        // Your logic for the employee dashboard
        return view('dashboard.manager.clients');
    }
}