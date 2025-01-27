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
        $repairType = RepairType::find($id);
        $repairType->delete();
        return redirect()->route('repairTypes.list');
    }

    public function create()
    {
        return view('dashboard.repairTypes.addRepairType');
    }

    public function store(Request $request)
    {
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

        return redirect()->route('repairTypes.list');
    }

    public function edit($id)
    {
        $repairType = RepairType::find($id);
        return view('dashboard.repairTypes.editRepairType', ['repairType' => $repairType]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:10',
            'duration' => 'required|numeric|min:30|multiple_of:30',
            'description' => 'required',
        ]);

        $repairType = RepairType::find($id);
        $repairType->name = $request->input('name');
        $repairType->price = $request->input('price');
        $repairType->duration = $request->input('duration');
        $repairType->description = $request->input('description');

        $repairType->save();

        return redirect()->route('repairTypes.list');
    }
}
