<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        
        // Live Revenue Analytics Queries
        $totalRevenue = \App\Models\Order::whereNotIn('status', ['cancelled'])->sum('total_amount');
        $activeOrders = \App\Models\Order::whereIn('status', ['new', 'processing'])->count();
        $deliveredOrders = \App\Models\Order::where('status', 'delivered')->count();

        // 6-Month Chart Data Vector mapping (Revenue & Orders Count)
        $salesData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = \App\Models\Order::whereNotIn('status', ['cancelled'])
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->sum('total_amount');
            
            $ordersCount = \App\Models\Order::whereNotIn('status', ['cancelled'])
                        ->whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
            
            $salesData['labels'][] = $month->format('M');
            $salesData['revenue'][] = (float) $revenue;
            $salesData['orders'][] = (int) $ordersCount;
        }

        return view('admin.dashboard', compact('totalUsers', 'adminUsers', 'totalRevenue', 'activeOrders', 'deliveredOrders', 'salesData'));
    }
}
