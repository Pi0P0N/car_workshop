<?php

namespace App\Http\Controllers;

use App\Models\RepairType;
use Illuminate\Http\Request;

class RepairTypeController extends Controller
{
    public function listRepairTypes()
    {
        $repairTypes = RepairType::all();
        return view('dashboard.repairTypes.listRepairTypes', ['repairTypes' => $repairTypes]);
    }

    public function destroy($id)
    {
        try {
            $repairType = RepairType::find($id);
            if (!$repairType) {
                return redirect()->route('repairTypes.list')->with('error', 'Nie znaleziono typu naprawy.');
            }
            $repairType->delete();
            return redirect()->route('repairTypes.list')->with('success', 'Typ naprawy został pomyślnie usunięty.');
        } catch (\Exception $e) {
            return redirect()->route('repairTypes.list')->with('error', 'Usunięcie typu naprawy nie powiodło się. Proszę spróbować ponownie.');
        }
    }

    public function create()
    {
        return view('dashboard.repairTypes.addRepairType');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:10',
            'duration' => 'required|numeric|min:30|multiple_of:30',
            'description' => 'required',
            ]);

            $repairType = new RepairType();
            $repairType->name = $request->input('name');
            $repairType->price = $request->input('price');
            $repairType->duration = $request->input('duration');
            $repairType->description = $request->input('description');

            $repairType->save();

            return redirect()->route('repairTypes.list')->with('success', 'Typ naprawy został pomyślnie dodany.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Dodanie typu naprawy nie powiodło się. Proszę spróbować ponownie.');
        }
    }

    public function edit($id)
    {
        try {
            $repairType = RepairType::find($id);
            if (!$repairType) {
                return redirect()->route('repairTypes.list')->with('error', 'Nie znaleziono typu naprawy.');
            }
            return view('dashboard.repairTypes.editRepairType', ['repairType' => $repairType]);
        } catch (\Exception $e) {
            return redirect()->route('repairTypes.list')->with('error', 'Nie udało się pobrać danych typu naprawy. Proszę spróbować ponownie.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:10',
            'duration' => 'required|numeric|min:30|multiple_of:30',
            'description' => 'required',
            ]);

            $repairType = RepairType::find($id);
            if (!$repairType) {
            return redirect()->route('repairTypes.list')->with('error', 'Nie znaleziono typu naprawy.');
            }

            $repairType->name = $request->input('name');
            $repairType->price = $request->input('price');
            $repairType->duration = $request->input('duration');
            $repairType->description = $request->input('description');

            $repairType->save();

            return redirect()->route('repairTypes.list')->with('success', 'Typ naprawy został pomyślnie zaktualizowany.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aktualizacja typu naprawy nie powiodła się. Proszę spróbować ponownie.');
        }
    }
}
