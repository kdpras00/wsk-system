<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
             // Admin sees generic dashboard or can delegate
             return view('admin.dashboard');
        } elseif ($user->role === 'manager') {
             // Manager sees Production Overview
             $totalYarn = \App\Models\YarnMaterial::count();
             $activeOrders = \App\Models\ProductionOrder::whereIn('status', ['Planned', 'In Progress'])->count();
             $pendingOrders = \App\Models\ProductionOrder::where('status', 'Pending Check')->get();
             $recentOrders = \App\Models\ProductionOrder::latest()->take(5)->get();
             
             return view('manager.dashboard', compact('totalYarn', 'activeOrders', 'pendingOrders', 'recentOrders'));
        } elseif ($user->role === 'operator') {
             // Operator sees Tasks
             $availableOrders = \App\Models\ProductionOrder::whereIn('status', ['Planned', 'In Progress'])->latest()->get();
             return view('operator.dashboard', compact('availableOrders'));
        }

        return view('admin.dashboard'); // Fallback
    }
}
