<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (view()->exists($id)) {
            if ($id == 'index') {
                $user = Auth::user();
                $invoice = Invoice::sum('total');
                $invoice_paid = Invoice::where('value_status', 1)->sum('total');
                $invoice_unpaid = Invoice::where('value_status', 0)->sum('total');
                $invoice_paid_parchel = Invoice::where('value_status', 3)->sum('total');
                $invoice_all_count = Invoice::count();
                $invoice_paid_count = Invoice::where('value_status', 1)->count();
                $invoice_unpaid_count = Invoice::where('value_status', 0)->count();
                $invoice_unpaid_parchel_count = Invoice::where('value_status', 3)->count();
                $invoice_paid_round = round($invoice_paid / $invoice, 4) * 100;
                $invoice_unpaid_round =  round($invoice_unpaid / $invoice, 4) * 100;
                $invoice_paid_parchelround = round($invoice_paid_parchel / $invoice, 4) * 100;
                //js
                $chartjs = app()->chartjs
                    ->name('barChartTest')
                    ->type('bar')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئياً', 'الفواتير المدفوعة كليا'])
                    ->datasets([
                        [
                            "label" => "نسبة الفواتير",
                            'backgroundColor' => ['#33A8FF', '#F0FF33', '#FF33E9'],
                            'data' => [$invoice_unpaid_round, $invoice_paid_parchelround, $invoice_paid_round]
                        ],
                        // [
                        //     "label" => "الفواتير المدفوعة جزئياً",
                        //     'backgroundColor' => ['#F0FF33'],
                        // ],
                        // [
                        //     "label" => "نسبة الفواتير",
                        //     'backgroundColor' => ['#FF33E9'],
                        // ]
                    ])
                    ->options([]);

                $chartjs2 = app()->chartjs
                    ->name('pieChartTest')
                    ->type('pie')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئياً', 'الفواتير المدفوعة كليا'])
                    ->datasets([
                        [
                            'backgroundColor' => ['#33A8FF', '#F0FF33', '#FF33E9'],
                            'hoverBackgroundColor' => ['#33A8FF', '#F0FF33', '#FF33E9'],
                            'data' => [$invoice_unpaid_round, $invoice_paid_parchelround, $invoice_paid_round]
                        ]
                    ])
                    ->options([]);

                return view($id, compact('invoice', 'invoice_paid', 'invoice_unpaid', 'invoice_paid_parchel', 'invoice_all_count', 'invoice_paid_count', 'invoice_unpaid_count', 'invoice_unpaid_parchel_count', 'chartjs', 'chartjs2', 'user'));
            } else {
                return view($id);
            }
        } else {
            return view('404');
        }

        return view($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
