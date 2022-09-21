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
            'one time' => 'once',
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
            'start' => ['required', 'date'],
            'weekly_day' => [
                'required_if:recurrance,weekly', 
                'in:,sunday,monday,tuesday,wednesday,thursday,friday,saturday'
            ]
        ]);

        $formFields['user_id'] = auth()->id();

        Bill::create($formFields);
        return redirect('/bills')->with('message', 'Bill Successfully Added.');
    }
}
