<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_teachers' => User::where('role', 'guru_bk')->count(),
            'total_guests' => User::where('is_guest', true)->count(),
            'total_manual_students' => User::where('role', 'siswa')->where('is_guest', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
