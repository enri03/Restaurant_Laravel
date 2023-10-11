<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }
    public function show(Request $request)
    {
        $request->validate([
            'dayStart' => 'required',
            'dayFinish' => 'required'
        ]);
        $dayStart = date('Y-m-d H:i:s', strtotime($request->dayStart . ' 00:00:00 '));
        $dayFinish = date('Y-m-d H:i:s', strtotime($request->dayFinish . ' 23:59:59 '));
        $sales = Sale::whereBetween('updated_at', [$dayStart, $dayFinish])->where('sale_status', 'paid');
        return view('report.showReport')
        ->with('dayStart', date('d/m/Y H:i:s', strtotime($request->dayStart . ' 00:00:00 ')))
        ->with('dayFinish', date('d/m/Y H:i:s', strtotime($request->dayFinish . ' 23:59:59 ')))
        ->with('totalSale', $sales->sum('total_price'))
        ->with('sales', $sales->paginate(4));
    }
}