<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('employee.dashboard');
    }

    public function getClientsList()
    {
        $clients = User::where('role', RolesEnum::Customer->value)->get();
        return view('dashboard.clients.clientsList', ['clients' => $clients]);
    }
    public function showClientDetails($id)
    {
        $client = User::find($id);
        $repairs = $client->repairs;
        $repairs = $repairs->sortBy('scheduled_date')->sortBy('scheduled_time');
        return view('dashboard.clients.clientDetails', ['client' => $client, 'repairs' => $repairs]);
    }

    public function destroy($id)
    {
        $client = User::find($id);
        $client->delete();
        return redirect('/clients');
    }

    public function edit($id)
    {
        $client = User::find($id);
        return view('dashboard.clients.editClient', ['client' => $client]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'phone_number' => 'required',
        ]);

        $client = User::find($request->input('id'));
        $client->first_name = $request->input('first_name');
        $client->last_name = $request->input('last_name');
        $client->email = $request->input('email');
        $client->role = $request->input('role');

        $client->save();

        return redirect()->route('clients.list');
    }
}
