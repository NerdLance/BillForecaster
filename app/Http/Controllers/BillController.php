<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Helpers\BillHelpers;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function daysBetweenTwoDays($day1, $day2) {
        $timeBetween = 0;

        if ($day1 == $day2) {
            $timeBetween = 0;
        } else if ($day1 < $day2) {
            $timeBetween = ($day2 - $day1);
        } else if ($day1 > $day2) {
            $daysInMonth = date('t');
            $daysLeftThisMonth = $daysInMonth - $day1;
            $timeBetween = ($daysLeftThisMonth + $day2);
        }

        return $timeBetween;
    }

    public function getDaysBetween(Bill $bill) {
        $dateDay = date('j');
        $dateWeekday = date('l');
        $dateMonth = date('n');
        $dateYear = date('Y');

        $timeBetween = 0;
        
        if ($bill->recurrance == 'monthly') {
            $timeBetween = $this->daysBetweenTwoDays($dateDay, $bill->day_month);
        } else if ($bill->recurrance == 'weekly') {
            if ($bill->day_week == $dateWeekday) {
                $timeBetween = 0;
            } else {
                $nextWeekdayString = 'next ' . strtolower($bill->day_week);
                $nextWeekdayTime = strtotime($nextWeekdayString);
                $nextWeekdayDay = date('j', $nextWeekdayTime);
                $timeBetween = $this->daysBetweenTwoDays($dateDay, $nextWeekdayDay);
            }
        }

        return $timeBetween;
    }

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
        $billsThisWeek = [];
        $billsThisWeekTotal = 0;

        foreach ($bills as $bill) {
            $timeBetween = $this->getDaysBetween($bill);

            if ($timeBetween <= 7) {
                $billsThisWeek[] = $bill;
                $billsThisWeekTotal += $bill->cost;
            }

            $billsNextDates[$bill->id] = $timeBetween;
        }

        return view('bills.index', [
            'bills' => $bills,
            'bills_suffix' => $billsSuffix,
            'bills_next' => $billsNextDates,
            'bills_this_week' => $billsThisWeek,
            'bills_this_week_total' => $billsThisWeekTotal
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
