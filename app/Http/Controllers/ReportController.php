<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report($date_start = null, $date_end = null){
        $title = 'Report';
        $orders = TransOrder::withTrashed()->with(['customer', 'details'])->get();
        $subtotals = TransOrderDetail::all();
        return view('admin.report.index', compact('title', 'orders', 'subtotals'));
    }

    public function reportFilter(Request $request)
    {
        $title = "Report";

        if ($request->date_start && $request->date_end) {
            $startDate = $request->date_start;
            $endDate = $request->date_end;

            $orders = TransOrder::withTrashed()->with(['customer', 'details'])->whereDate('order_date', '>=', $startDate)->whereDate('order_date', '<=', $endDate)->get();

            return view('admin.report.index', compact('title', 'orders'));
        }
        $orders = TransOrder::withTrashed()->with(['customer', 'details'])->get();

        return view('admin.report.index', compact('orders', 'title'));
    }

    public function printLaporan($report){
    $orders = TransOrder::withTrashed()
        ->with(['customer', 'details'])->get();

    return view('admin.report.print', compact('orders'));
    }

}
