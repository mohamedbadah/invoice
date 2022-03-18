<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = 1;
        $invoices = Invoice::onlyTrashed()->paginate(5);
        $current = $invoices->currentPage() - 1;
        return view('invoices.archive', compact('invoices', 'c', 'current'));
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
    public function update(Request $request)
    {
        $id = $request->invoiceId;
        $invoice = Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('restore', 'تمت استعادة العنصر بنجاح');
        return redirect()->route('user.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = Invoice::withTrashed()->where('id', $id)->first();
        $invoice->forceDelete();
        session()->flash('delete', 'لقد تم حذف العنصر نهائيا');
        return redirect()->back();
    }
}
