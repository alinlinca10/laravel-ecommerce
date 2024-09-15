<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store\Product;
use App\Models\Store\Order;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public $folder = 'admin/dashboard';
    public $link = '/admin/dashboard';

    public function index()
    {

        // $products = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //     ->whereYear('created_at', date('Y'))
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get();

        // $labels = [];
        // $data = [];

        // for ($i = 1; $i < 13; $i++) {
        //     $month = date('F', mktime(0, 0, 0, $i, 1));
        //     $count = 7;

        //     foreach ($products as $product) {
        //         if ($product->month == $i) {
        //             $count = $product->count;
        //             break;
        //         }
        //     }

        //     array_push($labels, $month);
        //     array_push($data, $count);
        // }

        // $datasets = [
        //     [
        //         'data' => $data,
        //     ]
        // ];

        $last_orders = Order::orderBy('created_at', 'DESC')->with('creator')->take(10)->get();

        $firstDayOfMonth = Carbon::now()->firstOfMonth()->format('Y-m-d');
        $lastDayOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $current_month_revenue = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
            ->sum('total_price');

        $last_month_revenue = Order::whereBetween('created_at', [Carbon::now()->firstOfMonth()->subMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d')])
            ->sum('total_price');

        $last_month_users = User::whereBetween('created_at', [Carbon::now()->firstOfMonth()->subMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d')])->count();
        $current_month_users = User::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->count();
        
        $last_month_orders = Order::whereBetween('created_at', [Carbon::now()->firstOfMonth()->subMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d')])->count();
        $current_month_orders = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->count();

        $currentYear = Carbon::now()->year;

        $monthlyRevenues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = Carbon::create($currentYear, $month, 1)->format('Y-m-d');
            $lastDayOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');

            $monthlyRevenue = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
                ->sum('total_price');
            
            // if($monthlyRevenue > 0)
                $monthlyRevenues[] = $monthlyRevenue;
        }

        $monthlyUsers = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = Carbon::create($currentYear, $month, 1)->format('Y-m-d');
            $lastDayOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');

            $monthlyUser = User::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->count();
            
            // if($monthlyUser > 0)
                $monthlyUsers[] = $monthlyUser;
        }

        $monthlyOrders = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDayOfMonth = Carbon::create($currentYear, $month, 1)->format('Y-m-d');
            $lastDayOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');

            $monthlyOrder = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->count();
            
            // if($monthlyOrder > 0)
                $monthlyOrders[] = $monthlyOrder;
        }

        return view('admin/dashboard.index')
            // ->with('datasets', $datasets)
            ->with('orders', $last_orders)
            ->with('current_month_revenue', $current_month_revenue)
            ->with('last_month_revenue', $last_month_revenue)
            ->with('current_month_orders', $current_month_orders)
            ->with('last_month_orders', $last_month_orders)
            ->with('monthlyRevenues', $monthlyRevenues)
            ->with('monthlyUsers', $monthlyUsers)
            ->with('monthlyOrders', $monthlyOrders)
            ->with('last_month_users', $last_month_users)
            ->with('current_month_users', $current_month_users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
