<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (Auth()->user()->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $countOrder = Orders::get()->count();
        $countProduct = Product::get()->count();
        $countAllPrice = Orders::where('status', 'completed')->sum('total_price');
        $countCash = Orders::where('status', 'completed')->where('payment_method', 'cash')->sum('total_price');
        $countQris = Orders::where('status', 'completed')->where('payment_method', 'qris')->sum('total_price');

        // Data untuk pie chart - pendapatan per bulan berdasarkan metode pembayaran
        // Tambahkan debug ini di controller untuk melihat data
        $monthlyPaymentRevenue = Orders::where('status', 'completed')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, payment_method, SUM(total_price) as total')
            ->groupBy('year', 'month', 'payment_method')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $latestMonth = $monthlyPaymentRevenue->first();
        $pieChartData = [];
        $pieChartLabels = [];
        $latestMonthName = '';

        if ($latestMonth) {
            $currentMonthData = $monthlyPaymentRevenue->where('year', $latestMonth->year)
                ->where('month', $latestMonth->month);

            $latestMonthName = date('F Y', mktime(0, 0, 0, $latestMonth->month, 1, $latestMonth->year));

            foreach ($currentMonthData as $data) {
                if ($data->total > 0) { // Pastikan total > 0
                    $pieChartLabels[] = ucfirst($data->payment_method);
                    $pieChartData[] = (float) $data->total; // Cast ke float
                }
            }
        } else {
            // Fallback jika tidak ada data
            $pieChartLabels = ['No Data'];
            $pieChartData = [0];
            $latestMonthName = 'No Data Available';
        }


        // Data untuk line chart - total price per bulan (semua metode pembayaran)
        $monthlyRevenue = Orders::where('status', 'completed')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk line chart
        $chartData = [];
        $chartLabels = [];

        foreach ($monthlyRevenue as $revenue) {
            $monthName = date('M Y', mktime(0, 0, 0, $revenue->month, 1, $revenue->year));
            $chartLabels[] = $monthName;
            $chartData[] = $revenue->total;
        }

        // Data 12 bulan terakhir berdasarkan metode pembayaran
        $last12MonthsPaymentRevenue = Orders::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, payment_method, SUM(total_price) as total')
            ->groupBy('year', 'month', 'payment_method')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk multi-line chart (QRIS vs Cash)
        $last12MonthsQrisData = [];
        $last12MonthsCashData = [];
        $last12MonthsLabels = [];

        // Buat array bulan untuk 12 bulan terakhir
        $monthsArray = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $monthName = $date->format('M Y');

            $monthsArray[] = [
                'year' => $year,
                'month' => $month,
                'name' => $monthName
            ];
        }

        foreach ($monthsArray as $monthInfo) {
            $last12MonthsLabels[] = $monthInfo['name'];

            $qrisRevenue = $last12MonthsPaymentRevenue
                ->where('year', $monthInfo['year'])
                ->where('month', $monthInfo['month'])
                ->where('payment_method', 'qris')
                ->sum('total');

            $cashRevenue = $last12MonthsPaymentRevenue
                ->where('year', $monthInfo['year'])
                ->where('month', $monthInfo['month'])
                ->where('payment_method', 'cash')
                ->sum('total');

            $last12MonthsQrisData[] = $qrisRevenue;
            $last12MonthsCashData[] = $cashRevenue;
        }

        return view('admin.dashboard.index', compact(
            'countOrder',
            'countProduct',
            'countAllPrice',
            'countCash',
            'countQris',
            'chartData',
            'chartLabels',
            'last12MonthsQrisData',
            'last12MonthsCashData',
            'last12MonthsLabels',
            'pieChartData',
            'pieChartLabels',
            'latestMonthName'
        ));
    }
}
