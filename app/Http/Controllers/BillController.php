<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    //

    public function index() {
        return view('bills.index');
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

        $formFields['user_id'] = auth()->id();

        Bill::create($formFields);
        return redirect('/bills')->with('message', 'Bill Successfully Added.');
    }
}
