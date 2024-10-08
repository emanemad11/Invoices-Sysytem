<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $count = Invoice::count();
        $sum = Invoice::sum('Total');

        $count1 = Invoice::where('Value_Status', 1)->count();
        $sum1 = Invoice::where('Value_Status', 1)->sum('Total');

        $count2 = Invoice::where('Value_Status', 2)->count();
        $sum2 = Invoice::where('Value_Status', 2)->sum('Total');

        $count3 = Invoice::where('Value_Status', 3)->count();
        $sum3 = Invoice::where('Value_Status', 3)->sum('Total');

        $percent1 = ($count > 0) ? ($count1 / $count) * 100 : 0;
        $percent2 = ($count > 0) ? ($count2 / $count) * 100 : 0;
        $percent3 = ($count > 0) ? ($count3 / $count) * 100 : 0;

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                ["label" => "الفواتير الغير المدفوعة", 'backgroundColor' => ['#ec5858'], 'data' => [$percent2]],
                ["label" => "الفواتير المدفوعة", 'backgroundColor' => ['#81b214'], 'data' => [$percent2]],
                ["label" => "الفواتير المدفوعة جزئيا", 'backgroundColor' => ['#ff9642'], 'data' => [$percent3]],
            ])->options([]);

        return view('dashboard', compact('chartjs', 'count', 'sum', 'count1', 'sum1', 'percent1', 'count2', 'sum2', 'percent2', 'count3', 'sum3', 'percent3'));
    }
}
