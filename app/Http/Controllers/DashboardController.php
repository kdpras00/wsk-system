<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Fetch instructions relevant to the user's role
        $instructions = \App\Models\Instruction::where('target_role', $user->role)
            ->orWhere('target_role', 'all')
            ->latest()
            ->take(5) // Just show latest 5 on dashboard
            ->get();

        if ($user->role === 'admin') {
             // Admin sees generic dashboard or can delegate
             return view('admin.dashboard', compact('instructions'));
        } elseif ($user->role === 'manager') {
             // Manager sees Production Overview
             $totalYarn = \App\Models\YarnMaterial::count();
             $activeOrders = \App\Models\ProductionOrder::whereIn('status', ['Planned', 'In Progress'])->count();
             $pendingOrders = \App\Models\ProductionOrder::where('status', 'Pending Check')->get();
             $recentOrders = \App\Models\ProductionOrder::latest()->take(5)->get();
             
             return view('manager.dashboard', compact('totalYarn', 'activeOrders', 'pendingOrders', 'recentOrders', 'instructions'));
        } elseif ($user->role === 'supervisor') {
             // Supervisor sees Production Overview (same as Manager but limited instructions management)
             $totalYarn = \App\Models\YarnMaterial::count();
             $activeOrders = \App\Models\ProductionOrder::whereIn('status', ['Planned', 'In Progress'])->count();
             $pendingOrders = \App\Models\ProductionOrder::where('status', 'Pending Check')->get();
             $recentOrders = \App\Models\ProductionOrder::latest()->take(5)->get();
             
             return view('supervisor.dashboard', compact('totalYarn', 'activeOrders', 'pendingOrders', 'recentOrders', 'instructions'));
        } elseif ($user->role === 'operator') {
             // Operator sees Tasks
             $availableOrders = \App\Models\ProductionOrder::whereIn('status', ['Planned', 'In Progress'])->latest()->get();
             return view('operator.dashboard', compact('availableOrders', 'instructions'));
        }

        return view('admin.dashboard', compact('instructions'));
    }
    
}
