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
        try {
            $client = User::find($id);
            $client->delete();
            return redirect('/clients')->with('success', 'Klient został pomyślnie usunięty.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się usunąć klienta. Proszę spróbować ponownie.');
        }
    }

    public function edit($id)
    {
        try {
            $client = User::find($id);
            return view('dashboard.clients.editClient', ['client' => $client]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się załadować danych klienta. Proszę spróbować ponownie.');
        }
    }

    public function update(Request $request)
    {
        try {
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
            $client->phone_number = $request->input('phone_number');

            $client->save();

            return redirect()->route('clients.list')->with('success', 'Dane klienta zostały zaktualizowane pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aktualizacja danych klienta nie powiodła się. Proszę spróbować ponownie.');
        }
    }
}
