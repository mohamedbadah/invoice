<?php

namespace App\Http\Controllers;

use session;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\section;
use Illuminate\Http\Request;
use App\Models\invoiceDetail;
use App\Notifications\AddInvoice;
use App\Models\Invoice_attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = 1;
        $invoices = Invoice::paginate(5);
        $current = $invoices->currentPage() - 1;
        return view('invoices.empty', compact('invoices', 'c', 'current'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = section::all();
        return view('invoices.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required'
        ]);
        if ($validation) {
            $invoice = new Invoice();
            $invoice->invoice_nubmer = $request->invoice_number;
            $invoice->invoice_Date = $request->invoice_Date;
            $invoice->due_date = $request->Due_date;
            $invoice->section_id = $request->Section;
            $invoice->product = $request->product;
            $invoice->Amount_collection = $request->Amount_collection;
            $invoice->Amount_commission = $request->Amount_Commission;
            $invoice->discount = $request->Discount;
            $invoice->rate_vat = $request->Rate_VAT;
            $invoice->value_vat = $request->Value_VAT;
            $invoice->total = $request->Total;
            $invoice->status = 'فاتورة غير مدفوعة';
            $invoice->value_status = 0;
            $invoice->note = $request->note;
            $isSaved = $invoice->save();
            if ($isSaved) {
                $invoice_id = Invoice::orderBy('id', 'desc')->first()->id;
                $invoice_details = new invoiceDetail();
                $invoice_details->invoice_id = $invoice_id;
                $invoice_details->invoice_number = $request->invoice_number;
                $invoice_details->product = $request->product;
                $invoice_details->section = $request->Section;
                $invoice_details->status = 'فاتورة غير مدفوعة';
                $invoice_details->value_status = 0;
                $invoice_details->note = $request->note;
                $invoice_details->user = Auth::user()->name;
                $invoice_details->save();
                if ($request->hasFile('pic')) {
                    $invoice_attach = new Invoice_attachment();
                    $ex = $request->file('pic')->getClientOriginalExtension();
                    $newName = "invoice_" . time() . '.' . $ex;
                    $request->file('pic')->move('uploade', $newName);
                    $invoice_attach->file_name = $newName;
                    $invoice_attach->invoice_number = $request->invoice_number;
                    $invoice_attach->created_by = Auth::user()->name;
                    $invoice_attach->invoice_id = $invoice_id;
                    $invoice_attach->save();
                }
                $user = User::first();
                Notification::send($user, new AddInvoice($invoice_id));
            }
            session()->flash('add', 'لقد تمت الاضافة بنجاح');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice_details = invoiceDetail::where('invoice_id', $invoice->id)->get();
        $attach = Invoice_attachment::where('invoice_id', $invoice->id)->get();
        return view('invoices.show', compact('invoice', 'invoice_details', 'attach'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = section::all();
        return view("invoices.edit", compact('sections', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validation = $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required'
        ]);
        if ($validation) {
            $invoice->invoice_nubmer = $request->invoice_number;
            $invoice->invoice_Date = $request->invoice_Date;
            $invoice->due_date = $request->Due_date;
            $invoice->section_id = $request->Section;
            $invoice->product = $request->product;
            $invoice->Amount_collection = $request->Amount_collection;
            $invoice->Amount_commission = $request->Amount_Commission;
            $invoice->discount = $request->Discount;
            $invoice->rate_vat = $request->Rate_VAT;
            $invoice->value_vat = $request->Value_VAT;
            $invoice->total = $request->Total;
            $invoice->status = 'فاتورة غير مدفوعة';
            $invoice->value_status = 0;
            $invoice->note = $request->note;
            $update = $invoice->save();
            if ($update) {
                // $invoice_id = Invoice::orderBy('id', 'desc')->first()->id;
                $invoice_details = invoiceDetail::where('invoice_id', $invoice->id)->first();
                $invoice_details->invoice_id = $invoice->id;
                $invoice_details->invoice_number = $invoice->invoice_nubmer;
                $invoice_details->product = $invoice->product;
                $invoice_details->section =   $invoice->section_id;
                $invoice_details->status = 'فاتورة غير مدفوعة';
                $invoice_details->value_status = 0;
                $invoice_details->note =  $invoice->note;
                $invoice_details->user = Auth::user()->name;
                $invoice_details->save();
                $invoice_attach = Invoice_attachment::where('invoice_id', $invoice->id)->first();
                if ($invoice_attach) {
                    $invoice_attach->invoice_number =  $invoice->invoice_nubmer;
                    $invoice_attach->created_by = Auth::user()->name;
                    $invoice_attach->save();
                }
            }
            session()->flash('add', 'لقد تمت الاضافة بنجاح');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $attach = Invoice_attachment::where('invoice_id', $invoice->id)->first();
        // $isDelete = $invoice->delete();
        // if ($isDelete) {
        //     session()->flash('delete', 'لقد تم  حذف العنصر بنجاح');
        //     return redirect()->back();
        // }
        if (!$request->archive) {


            if (!empty($attach->invoice_number)) {
                Storage::disk('upload')->delete($attach->file_name);
            }
            $invoice->forceDelete();
            session()->flash('delete', 'لقد تم  حذف العنصر بنجاح');
            return redirect()->back();
        } else {
            $invoice->delete();
            session()->flash('archive', 'لقد تمت أرشفة الفاتورة بنجاح ');
            return redirect()->route('user.archive.index');
        }
    }
    public function getPage($id)
    {
        $product = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($product);
    }
    public function getview($file_name)
    {
        $file = Storage::disk('upload')->getDriver()->getAdapter()->applyPathPrefix($file_name);
        return response()->file($file);
    }
    public function getDowanload($file_name)
    {
        $file = Storage::disk('upload')->getDriver()->getAdapter()->applyPathPrefix($file_name);
        return response()->download($file);
    }
    public function edit_status($id)
    {
        $invoices = Invoice::findOrFail($id);
        return view('invoices.edit_status', ['invoices' => $invoices]);
    }
    public function update_status($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $request->validate([
            'Status' => 'required',
            'Payment_Date' => 'required'
        ]);
        if ($request->Status == 'full') {
            $invoice->update([
                'status' => $request->Status,
                'value_status' => 1,
                'payment_Date' => $request->Payment_Date
            ]);
            invoiceDetail::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'section' => $request->Section,
                'product' => $request->product,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'payment_date' => $request->Payment_Date
            ]);
        } else {
            $invoice->update([
                'status' => $request->Status,
                'value_status' => 0,
                'payment_Date' => $request->Payment_Date
            ]);
            invoiceDetail::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'section' => $request->Section,
                'product' => $request->product,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'user' => Auth::user()->name,
                'payment_date' => $request->Payment_Date
            ]);
        }
        session('update_status', 'لقد تم تحديث حالة الدفع بنجاح');
        return redirect()->route('user.invoices.index');
    }
    public function invoice_paid()
    {
        $c = 1;
        $invoices = Invoice::where('value_status', 1)->paginate(5);
        $current = $invoices->currentPage() - 1;
        return view('invoices.invoice_paid', compact('invoices', 'current', 'c'));
    }
    public function invoice_unpaid()
    {
        $c = 1;
        $invoices = Invoice::where('value_status', 0)->paginate(5);
        $current = $invoices->currentPage() - 1;
        return view('invoices.invoice_unpaid', compact('invoices', 'current', 'c'));
    }
    public function invoice_partical()
    {
        $c = 1;
        $invoices = Invoice::where('value_status', 3)->paginate(5);
        $current = $invoices->currentPage() - 1;
        return view('invoices.invoice_partical', compact('invoices', 'current', 'c'));
    }
    public function print_invoice($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        // $invoice = Invoice::findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }
}
