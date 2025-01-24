<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnauthorizedController extends Controller
{
    public function show()
    {
        return response()->view('errors.unauthorized', [], 403);
    }
}