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
    // FOR EMPLOYEES START
    public function getClientsList()
    {
        //find all users with role = Roles::Customer
        $clients = User::where('role', RolesEnum::Customer->value)->get();
        //pass the clients to the view
        return view('dashboard.clients.clientsList', ['clients' => $clients]);
        // return view('dashboard.clients.clientsList');
    }
    public function showClientDetails($id)
    {
        //find the user with the given id
        $client = User::find($id);
        //find all repairs for the user
        $repairs = $client->repairs;
        //pass the client to the view
        return view('dashboard.clients.clientDetails', ['client' => $client, 'repairs' => $repairs]);
    }

    public function destroy($id)
    {
        //find the user with the given id
        $client = User::find($id);
        //delete the user
        $client->delete();
        //redirect to the clients list
        return redirect('/clients');
    }

    // FOR EMPLOYEES STOP

    // FOR CLIENTS START

}
