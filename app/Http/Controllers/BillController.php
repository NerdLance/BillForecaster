<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Http\Request;

class BillController extends Controller
{
    //

    public function index() {
        $billsSuffix = [
            'one' => 'once',
            'daily' => 'day',
            'weekly' => 'week',
            'monthly' => 'month',
            'quarterly' => 'quarter',
            'yearly' => 'year'
        ];

        $bills = auth()->user()->bills()->get();

        $billsNextDates = [];

        foreach ($bills as $bill) {
            $dateDay = date('j');
            $dateMonth = date('n');
            $dateYear = date('Y');
            $dateFull = $dateYear . "-" . $dateMonth . "-" . $dateDay;

            $timeBetween = '';
            if (strtotime($bill->start) > strtotime($dateFull)) {
                $now = time();
                $next = strtotime($bill->start);
                $timeDiff = $next - $now;

                $timeBetween = round($timeDiff / (60 * 60 * 24)) . ' days';
            } else {
                /* Calculate Time Between Now and Due Date */
                //
                //

                $timeBetween = 'Calculating';
            }

            $billsNextDates[$bill->id] = $timeBetween;
        }

        return view('bills.index', [
            'bills' => $bills,
            'bills_suffix' => $billsSuffix,
            'bills_next' => $billsNextDates
        ]);
    }

    public function create() {
        return view('bills.create');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'cost' => ['required', 'numeric'],
            'recurrance' => ['required', 'in:daily,weekly,monthly,quarterly,yearly'],
            'start' => ['required', 'date']
        ]);

        $dateToTime = strtotime($request['start']);

        $formFields['day_week'] = date('l', $dateToTime);
        $formFields['day_month'] = date('j', $dateToTime);
        $formFields['month'] = date('n', $dateToTime);
        $formFields['year'] = date('Y', $dateToTime);

        $formFields['user_id'] = auth()->id();

        Bill::create($formFields);
        return redirect('/bills')->with('message', 'Bill Successfully Added.');
    }

    public function edit(Bill $bill) {
        return view('bills.edit', [
            'bill' => $bill
        ]);
    }

    public function update(Request $request, Bill $bill) {
        if ($bill->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'cost' => ['required', 'numeric'],
            'recurrance' => ['required', 'in:one,daily,weekly,monthly,quarterly,yearly'],
            'start' => ['required', 'date']
        ]);

        $dateToTime = strtotime($request['start']);

        $formFields['day_week'] = date('l', $dateToTime);
        $formFields['day_month'] = date('j', $dateToTime);
        $formFields['month'] = date('n', $dateToTime);
        $formFields['year'] = date('Y', $dateToTime);
        
        $bill->update($formFields);
        return redirect('/bills')->with('message', 'Bill Successfully Updated');
    }

    public function destroy(Bill $bill) {
        if ($bill->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $bill->delete();
        return redirect('/bills')->with('message', 'Bill Successfully Deleted');
    }
}
