<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('dashboard.employee.employeePanel');
    }

    public function listEmployees()
    {
        $employees = User::where('role', RolesEnum::Employee->value)->get();
        return view('dashboard.employee.listEmployees', ['employees' => $employees]);
    }

    public function edit($id)
    {
        try {
            $employee = User::find($id);
            return view('dashboard.employee.editEmployee', ['employee' => $employee]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się załadować danych pracownika. Proszę spróbować ponownie.');
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
            ]);

            $employee = User::find($request->input('id'));
            $employee->first_name = $request->input('first_name');
            $employee->last_name = $request->input('last_name');
            $employee->email = $request->input('email');
            $employee->role = $request->input('role');

            $employee->save();

            return redirect()->route('employees.list')->with('success', 'Dane pracownika zostały zaktualizowane pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aktualizacja danych pracownika nie powiodła się. Proszę spróbować ponownie.');
        }
    }

    public function destroy($id)
    {
        try {
            $employee = User::find($id);
            $employee->delete();
            return redirect()->route('employees.list')->with('success', 'Pracownik został pomyślnie usunięty.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się usunąć pracownika. Proszę spróbować ponownie.');
        }
    }
}