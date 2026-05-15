<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $type = $request->query('type', 'pelaporan'); // default to pelaporan
        return view('guest.lapor', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:pelaporan,konsultasi',
            'priority' => 'required|in:low,medium,high'
        ]);

        Report::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'is_anonymous' => auth()->user()->is_guest ? true : false, // if manual student, not anonymous by default (or you can make it a checkbox)
        ]);

        return redirect()->route('lapor.success');
    }

    public function success()
    {
        return view('guest.success');
    }
}
