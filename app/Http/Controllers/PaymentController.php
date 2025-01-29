<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Enums\PaymentStatusEnum;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.payments.paymentsPanel');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        try {
            $highestVersion = Payment::where('repair_id', $request->repair_id)->max('version');

            Payment::create([
                'repair_id' => $request->repair_id,
                'version' => $highestVersion + 1,
                'status' => $request->status,
                'employee_id' =>  auth()->id()
            ]);

            return redirect()->back()->with('success', 'Płatność zaktualizowana pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się zaktualizować płatności. Proszę spróbować ponownie.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    /**
     * List all payments for a specific day.
     */
    public function listByDate(Request $request)
    {
        try {
            $date = $request->input('date', now()->toDateString());
            $previousDay = date('Y-m-d', strtotime($date . ' -1 day'));
            $nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
            $payments = Payment::whereDate('created_at', $date)
                    ->where('status', PaymentStatusEnum::Paid->value)
                    ->whereIn('id', function ($query) {
                        $query->selectRaw('MAX(id)')
                              ->from('payments')
                              ->groupBy('repair_id');
                    })
                    ->orderBy('version', 'desc')
                    ->get();
            $paymentStatuses = PaymentStatusEnum::getAllWithLabels();

            return view('dashboard.payments.paymentsDay', compact('payments', 'date', 'previousDay', 'nextDay', 'paymentStatuses'))
            ->with('success', 'Lista płatności pobrana pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać listy płatności. Proszę spróbować ponownie.');
        }
    }

    /**
     * Display the history of a single payment.
     */
    public function history(int $repair_id)
    {
        try {
            $paymentHistory = Payment::where('repair_id', $repair_id)
                                     ->orderBy('version', 'desc')
                                     ->get();

            return view('dashboard.payments.paymentHistory', compact('paymentHistory'))
                   ->with('success', 'Historia płatności pobrana pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać historii płatności. Proszę spróbować ponownie.');
        }
    }

    /**
     * List all pending payments where the repair is past its term.
     */
    public function listPendingPastTerm()
    {
        try {
            $pendingPayments = Payment::where('status', PaymentStatusEnum::Pending->value)
                                      ->whereHas('repair', function ($query) {
                                          $query->where('scheduled_date', '<', now())
                                                ->orWhere(function ($query) {
                                                    $query->where('scheduled_date', '=', now()->toDateString())
                                                          ->where('scheduled_time', '<', now()->toTimeString());
                                                });
                                      })
                                      ->whereIn('id', function ($query) {
                                          $query->selectRaw('MAX(id)')
                                                ->from('payments')
                                                ->groupBy('repair_id');
                                      })
                                      ->orderBy('version', 'desc')
                                      ->get();
            $paymentStatuses = PaymentStatusEnum::getAllWithLabels();
            return view('dashboard.payments.pendingPastTerm', compact('pendingPayments', 'paymentStatuses'))
                   ->with('success', 'Lista zaległych płatności pobrana pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać listy zaległych płatności. Proszę spróbować ponownie.');
        }
    }

    /**
     * Summarize payments for a specific month.
     */
    public function summarizeMonth(Request $request)
    {
        try {
            $month = $request->input('month', now()->format('Y-m'));
            $payments = Payment::whereYear('created_at', date('Y', strtotime($month)))
                               ->whereMonth('created_at', date('m', strtotime($month)))
                               ->whereIn('id', function ($query) {
                                $query->selectRaw('MAX(id)')
                                      ->from('payments')
                                      ->groupBy('repair_id');
                                })
                               ->get()
                               ;

            $summary = $payments->groupBy('status')->mapWithKeys(function ($group, $status) {
                return [PaymentStatusEnum::getLabel($status) => $group->count()];
            });

            $totalRepairs = $payments->groupBy('repair_id')->count();
            $totalEarnings = $payments->where('status', PaymentStatusEnum::Paid->value)
                                      ->sum(function ($payment) {
                                          return $payment->repair->repairtype->price;
                                      });

            return view('dashboard.payments.monthSummary', compact('summary', 'month', 'totalRepairs', 'totalEarnings'))
                   ->with('success', 'Podsumowanie płatności za miesiąc pobrane pomyślnie.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się pobrać podsumowania płatności za miesiąc. Proszę spróbować ponownie.');
        }
    }

}
