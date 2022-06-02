<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\section;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $sections = section::all();
        return view('report.report_index', compact('sections'));
    }
    public function Search_invoices(Request $request)
    {

        $rdio = $request->rdio;


        // في حالة البحث بنوع الفاتورة

        if ($rdio == 1) {

            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at == '') {

                $invoices = Invoice::where('status', '=', $request->type)->get();
                $type = $request->type;
                return view('report.report_index')->withDetails($invoices);
            }

            // في حالة تحديد تاريخ استحقاق
            else {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoice::whereBetween('invoice_Date', [$start_at, $end_at])->where('status', '=', $request->type)->get();
                return view('report.report_index')->withDetails($invoices);
            }
        }

        //====================================================================

        // في البحث برقم الفاتورة
        else {

            $invoices = Invoice::where('invoice_nubmer', '=', $request->invoice_number)->get();
            return view('report.report_index')->withDetails($invoices);
        }
    }
    public function indexCustomer()
    {
        $sections = section::all();
        return view('report.customer', ['sections' => $sections]);
    }
    public function  Search_customers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $invoices = Invoice::where('section_id', $request->Section)->where('product', $request->product)->get();
            $sections = section::all();
            return view('report.customer', compact('sections'))->withDetails($invoices);
        } else {
            $start_date = date($request->start_at);
            $end_date = date($request->end_at);
            $invoices = Invoice::whereBetween('invoice_Date', [$start_date, $end_date])->where('section_id', $request->Section)->where('product', $request->product)->get();
            $sections = section::all();
            return view('report.customer', compact('sections'))->withDetails($invoices);
        }
    }
}
