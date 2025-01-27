<?php

namespace App\Http\Controllers;

use App\Enums\RepairStatusEnum;
use App\Models\Repairs;
use App\Models\RepairType;
use Illuminate\Http\Request;
use App\Services\RepairsService;
use App\Http\Requests\StoreRepairsRequest;
use App\Http\Requests\UpdateRepairsRequest;

class RepairsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $repairTypes = RepairType::all();
        return view('dashboard.repairs.addRepair', ['repairTypes' => $repairTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairsRequest $request)
    {
        $request->validate([
            'repair_type' => 'required|exists:repair_types,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'description' => 'required',
        ]);

        $repair = new Repairs();
        $repair->client_id = auth()->id();
        $repair->created_at = now();
        $repair->updated_at = now();
        $repair->repair_type = $request->input('repair_type');
        $repair->scheduled_date = $request->input('scheduled_date');
        $repair->scheduled_time = $request->input('scheduled_time');
        $repair->description = $request->input('description');
        $repair->status = RepairStatusEnum::Pending;
        $repair->save();

        return redirect('/');
    }

    public function listRepairsForDate(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $previousDay = date('Y-m-d', strtotime($date . ' -1 day'));
        $nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
        $repairs = app(RepairsService::class)->getRepairsForDate($date);
        return view('dashboard.repairs.repairsList', ['repairs' => $repairs, 'date' => $date, 'previousDay' => $previousDay, 'nextDay' => $nextDay]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Repairs $repairs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $repairs = Repairs::find($id);
        if (!$repairs) {
            return redirect()->route('repairs.list');
        }
        $repairTypes = RepairType::all();
        return view('dashboard.repairs.editRepair', ['repair' => $repairs, 'repairTypes' => $repairTypes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairsRequest $request, Repairs $repairs)
    {
        $request->validate([
            'repair_type' => 'required|exists:repair_types,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'description' => 'required',
        ]);

        $repair = Repairs::find($request->input('repair_id'));
        $repair->status = $request->input('status');
        $repair->repair_type = $request->input('repair_type');
        $repair->scheduled_date = $request->input('scheduled_date');
        $repair->scheduled_time = $request->input('scheduled_time');
        $repair->description = $request->input('description');

        $repair->save();

        return redirect()->route('repairs.list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $repairs = Repairs::find($id);
        if ($repairs) {
            $repairs->delete();
        }
        return redirect()->route('repairs.list');
    }
    public function getAvailableRepairTimes(Request $request)
    {
        $date = $request->input('date');
        $repairType = $request->input('repair_type');
        $repairId = $request->input('repair_id', null);
        $availableTimes = app(RepairsService::class)->getAvailableRepairTimes($date, $repairType, $repairId);
        return response()->json($availableTimes);
    }
}
