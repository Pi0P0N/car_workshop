<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
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
    public function create(Request $request)
    {
        $repairTypes = RepairType::all();
        $selectedRepairType = $request->query('repair_type');
        return view('dashboard.repairs.addRepair', [
            'repairTypes' => $repairTypes,
            'selectedRepairType' => $selectedRepairType
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairsRequest $request)
    {
        try {
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

            // Add payment with status 1
            $payment = new \App\Models\Payment();
            $payment->repair_id = $repair->id;
            $payment->employee_id = null;
            $payment->status = PaymentStatusEnum::Pending->value;
            $payment->version = 1;
            $payment->created_at = now();
            $payment->updated_at = now();
            $payment->save();

            return redirect('/')->with('success', 'Naprawa została pomyślnie dodana.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Dodanie naprawy nie powiodło się. Proszę spróbować ponownie.');
        }
    }

    public function listRepairsForDate(Request $request)
    {
        try {
            $date = $request->input('date', now()->toDateString());
            $previousDay = date('Y-m-d', strtotime($date . ' -1 day'));
            $nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
            $repairs = app(RepairsService::class)->getRepairsForDate($date);
            $paymentStatuses = PaymentStatusEnum::getAllWithLabels();
            return view('dashboard.repairs.repairsList', ['repairs' => $repairs, 'date' => $date, 'previousDay' => $previousDay, 'nextDay' => $nextDay, 'paymentStatuses' => $paymentStatuses]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać listy napraw. Proszę spróbować ponownie.');
        }
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
        try {
            $repairs = Repairs::find($id);
            if (!$repairs) {
                return redirect()->route('repairs.list')->with('error', 'Nie znaleziono naprawy.');
            }
            $repairTypes = RepairType::all();
            return view('dashboard.repairs.editRepair', ['repair' => $repairs, 'repairTypes' => $repairTypes]);
        } catch (\Exception $e) {
            return redirect()->route('repairs.list')->with('error', 'Nie udało się pobrać danych naprawy. Proszę spróbować ponownie.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairsRequest $request, Repairs $repairs)
    {
        try {
            $request->validate([
            'repair_type' => 'required|exists:repair_types,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'description' => 'required',
            ]);

            $repair = Repairs::find($request->input('repair_id'));
            if (!$repair) {
                return redirect()->route('repairs.list')->with('error', 'Nie znaleziono naprawy.');
            }

            $repair->status = $request->input('status');
            $repair->repair_type = $request->input('repair_type');
            $repair->scheduled_date = $request->input('scheduled_date');
            $repair->scheduled_time = $request->input('scheduled_time');
            $repair->description = $request->input('description');

            $repair->save();

            return redirect()->route('repairs.list')->with('success', 'Naprawa została pomyślnie zaktualizowana.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aktualizacja naprawy nie powiodła się. Proszę spróbować ponownie.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $repairs = Repairs::find($id);
            if ($repairs) {
                $repairs->delete();
                return redirect()->route('repairs.list')->with('success', 'Naprawa została pomyślnie usunięta.');
            } else {
                return redirect()->route('repairs.list')->with('error', 'Nie znaleziono naprawy.');
            }
        } catch (\Exception $e) {
            return redirect()->route('repairs.list')->with('error', 'Nie udało się usunąć naprawy. Proszę spróbować ponownie.');
        }
    }
    public function getAvailableRepairTimes(Request $request)
    {
        try {
            $date = $request->input('date');
            $repairType = $request->input('repair_type');
            $repairId = $request->input('repair_id', null);
            $availableTimes = app(RepairsService::class)->getAvailableRepairTimes($date, $repairType, $repairId);
            return response()->json($availableTimes);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać dostępnych terminów napraw. Proszę spróbować ponownie.');
        }
    }
}
